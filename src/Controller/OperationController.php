<?php

namespace App\Controller;

use App\Entity\Category\BaseCategory;
use App\Entity\Operation\BaseOperation;
use App\Entity\Operation\OperationExpense;
use App\Entity\Operation\OperationIncome;
use App\Enum\OperationTypeEnum;
use App\Repository\Operation\BaseOperationRepository;
use App\Repository\Operation\OperationExpenseRepository;
use App\Repository\Operation\OperationIncomeRepository;
use App\Service\OperationList;
use App\Service\OperationNameFormatter;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @Route("/operation")
 */
class OperationController extends AbstractController
{
    /** @var EntityManagerInterface */
    private $em;

    /** @var OperationNameFormatter */
    private $operationNameFormatter;

    /** @var OperationList */
    private $operationList;

    /**
     * OperationController constructor.
     *
     * @param EntityManagerInterface $em
     * @param OperationNameFormatter $operationNameFormatter
     * @param OperationList          $operationList
     */
    public function __construct(
        EntityManagerInterface $em,
        OperationNameFormatter $operationNameFormatter,
        OperationList $operationList
    ) {
        $this->em                     = $em;
        $this->operationNameFormatter = $operationNameFormatter;
        $this->operationList          = $operationList;
    }

    /**
     * @Route("/", name="operation_index", methods={"GET"})
     *
     * @return Response
     *
     * @throws NoResultException
     * @throws NonUniqueResultException
     */
    public function index(): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $user              = $this->getUser();
        $groupedOperations = $this->operationList->getGroupedByDays($user);

        /** @var OperationExpenseRepository $operationExpenseRepo */
        $operationExpenseRepo = $this->getDoctrine()->getRepository(OperationExpense::class);
        $expenseSum           = $operationExpenseRepo->getUserExpenseSum($user);
        /** @var OperationIncomeRepository $operationIncomeRepo */
        $operationIncomeRepo  = $this->getDoctrine()->getRepository(OperationIncome::class);
        $incomeSum            = $operationIncomeRepo->getUserIncomeSum($user);

        return $this->render('operation/index.html.twig', [
            'groupedOperations' => $groupedOperations,
            'expenseSum'        => $expenseSum,
            'incomeSum'         => $incomeSum,
        ]);
    }

    /**
     * @Route("/new/{operationSlug}", name="operation_new", methods={"GET", "POST"})
     *
     * @param string  $operationSlug
     * @param Request $request
     *
     * @return Response
     */
    public function new(string $operationSlug, Request $request): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        /** @var UserInterface $user */
        $user = $this->getUser();

        $operationType = $this->operationNameFormatter->getTypeBySlug($operationSlug);
        $this->validateOperationType($operationType);

        $operationClassName = $this->getOperationClassName($operationType);
        /** @var BaseOperation $operation */
        $operation = new $operationClassName();
        $operation->setUser($user);

        $formClassName = $this->getFormClassName($operationType);
        $form = $this->createForm($formClassName, $operation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var BaseOperation $operation */
            $operation = $form->getData();

            $this->em->persist($operation);
            $this->em->flush();

            return $this->redirectToRoute('operation_index');
        }

        return $this->render('operation/new.html.twig', [
            'operationForm' => $form->createView(),
            'operationName' => $this->operationNameFormatter->getNameBySlug($operationSlug),
            'operationSlug' => $operationSlug,
        ]);
    }

    /**
     * @Route("/copy/{id}", name="operation_copy", methods={"GET", "POST"})
     *
     * @param OperationIncome $operation
     * @param Request   $request
     *
     * @return Response
     */
    public function copy(OperationIncome $operation, Request $request): Response
    {
        $this->denyAccessUnlessGranted('OPERATION_COPY', $operation);

        $clonedOperation = clone $operation;
        $form            = $this->createForm(OperationType::class, $clonedOperation, [
            'operation_type' => $clonedOperation->getType(),
        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var OperationIncome $clonedOperation */
            $clonedOperation = $form->getData();

            $this->em->persist($clonedOperation);
            $this->em->flush();

            return $this->redirectToRoute('operation_index');
        }

        $operationType = $clonedOperation->getType();

        return $this->render('operation/copy_'.OperationTypeEnum::getTypeSlug($operationType).'.html.twig', [
            'operationForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/edit/{id}", name="operation_edit", methods={"GET", "POST"})
     *
     * @param OperationIncome $operation
     * @param Request   $request
     *
     * @return Response
     */
    public function edit(OperationIncome $operation, Request $request): Response
    {
        $this->denyAccessUnlessGranted('OPERATION_EDIT', $operation);

        $form = $this->createForm(OperationType::class, $operation, [
            'operation_type' => $operation->getType(),
        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var OperationIncome $operation */
            $operation = $form->getData();

            $this->em->persist($operation);
            $this->em->flush();

            return $this->redirectToRoute('operation_index');
        }

        $operationType = $operation->getType();

        return $this->render('operation/edit_'.OperationTypeEnum::getTypeSlug($operationType).'.html.twig', [
            'operationForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="operation_delete", methods={"DELETE"})
     *
     * @param OperationIncome $operation
     *
     * @return Response
     */
    public function delete(OperationIncome $operation): Response
    {
        $this->denyAccessUnlessGranted('OPERATION_DELETE', $operation);

        $this->em->remove($operation);
        $this->em->flush();

        return new JsonResponse([       // TODO fix it
            'data' => 'Operation deleted successfully',
        ]);
    }

    /**
     * Returns operation with the given ID for provided operation name.
     *
     * @param string  $operationName
     * @param integer $id
     *
     * @return BaseOperation
     *
     * @throws NotFoundHttpException If category was not found
     */
    private function findOperation(string $operationName, int $id): BaseOperation
    {
        $operationClassName = $this->getOperationClassName($operationName);
        /** @var BaseOperationRepository $operationRepo */
        $operationRepo = $this->getDoctrine()->getRepository($operationClassName);
        /** @var BaseCategory|null $category */
        $category = $operationRepo->find($id);
        if (!$category) {
            throw $this->createNotFoundException(ucfirst($operationName) . ' category not found.');
        }

        return $category;
    }

    /**
     * Returns operation class name for the provided operation type.
     *
     * @param integer|null $operationType
     *
     * @return string|null
     */
    private function getOperationClassName(?int $operationType): ?string
    {
        $categoryClassName      = null;
        $operationNameCamelCase = null;
        if ($operationType) {
            $operationNameCamelCase = $this->operationNameFormatter->getCamelCaseByType($operationType);
        }
        if ($operationNameCamelCase) {
            $categoryClassName = 'App\\Entity\\Operation\\' . 'Operation'. $operationNameCamelCase;
        }

        return $categoryClassName;
    }

    /**
     * Returns class name for an operation form type depending on the operation type.
     *
     * @param integer|null $operationType
     *
     * @return string|null
     */
    private function getFormClassName(?int $operationType): ?string
    {
        $formClassName          = null;
        $operationNameCamelCase = null;
        if ($operationType) {
            $operationNameCamelCase = $this->operationNameFormatter->getCamelCaseByType($operationType);
        }
        if ($operationNameCamelCase) {
            $formClassName = 'App\\Form\\Operation\\' . 'Operation' . $operationNameCamelCase . 'Type';
        }

        return $formClassName;
    }

    /**
     * Throws an exception if an operation class for the operation type does not exist.
     *
     * @param integer|null $operationType
     *
     * @throws BadRequestHttpException If the provided operation type is not supported.
     */
    private function validateOperationType(?int $operationType): void
    {
        $operationClassName = $this->getOperationClassName($operationType);
        if (!class_exists($operationClassName)) {
            throw new BadRequestHttpException('Unsupported operation type.');
        }
    }
}
