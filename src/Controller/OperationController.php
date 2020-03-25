<?php

namespace App\Controller;

use App\Entity\Category\BaseCategory;
use App\Entity\Operation\BaseOperation;
use App\Entity\Operation\OperationIncome;
use App\Enum\OperationTypeEnum;
use App\Form\OperationType;
use App\Repository\Operation\OperationRepository;
use App\Service\OperationList;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class OperationController
 * @package App\Controller
 *
 * @Route("/operation")
 */
class OperationController extends AbstractController
{
    /** @var OperationList */
    private $operationList;

    /**
     * OperationController constructor.
     *
     * @param OperationList $operationList
     */
    public function __construct(OperationList $operationList)
    {
        $this->operationList = $operationList;
    }

    /**
     * @Route("/", name="operation_index", methods={"GET"})
     *
     * @return Response
     */
    public function index(): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $user              = $this->getUser();
//        $groupedOperations = $this->operationList->getGroupedByDays($user);

        /** @var OperationRepository $operationRepo */
//        $operationRepo = $this->getDoctrine()->getRepository(BaseOperation::class);
//        $expenseSum    = $operationRepo->getUserExpenseSum($user);
//        $incomeSum     = $operationRepo->getUserIncomeSum($user);



        $groupedOperations = [];
        $expenseSum    = 0;
        $incomeSum     = 0;


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
        $this->operationSlugValidate($operationSlug);

        $operation = new OperationIncome();

        $form = $this->createForm(OperationType::class, $operation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UserInterface $user */
            $user = $this->getUser();
            /** @var OperationIncome $operation */
            $operation = $form->getData();
            $operation->setUser($user);

            $em = $this->getDoctrine()->getManager();
            $em->persist($operation);
            $em->flush();

            return $this->redirectToRoute('operation_index');
        }

        return $this->render('operation/new_'.$operationSlug.'.html.twig', [
            'operationForm' => $form->createView(),
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

            $em = $this->getDoctrine()->getManager();
            $em->persist($clonedOperation);
            $em->flush();

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

            $em = $this->getDoctrine()->getManager();
            $em->persist($operation);
            $em->flush();

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

        $em = $this->getDoctrine()->getManager();
        $em->remove($operation);
        $em->flush();

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
     * @return BaseCategory
     *
     * @throws NotFoundHttpException If category was not found
     */
    private function findOperation(string $operationName, int $id): BaseOperation
    {
        $operationClassName = $this->getClassNameByOperationName($operationName);
        /** @var OperationRepository $operationRepo */
        $operationRepo = $this->getDoctrine()->getRepository($operationClassName);
        /** @var BaseCategory|null $category */
        $category = $operationRepo->find($id);
        if (!$category) {
            throw $this->createNotFoundException(ucfirst($operationName) . ' category not found.');
        }

        return $category;
    }

    /**
     * Returns class name for an operation depending on the operation name.
     *
     * @param string $operationName
     *
     * @return string
     */
    private function getClassNameByOperationName(string $operationName): string
    {
        return 'App\\Entity\\Operation\\' . 'Operation'. ucfirst($operationName);
    }

    /**
     * Returns class name for an operation form type depending on the operation name.
     *
     * @param string $operationName
     *
     * @return string
     */
    private function getFormNameByOperationName(string $operationName): string
    {
        return 'App\\Form\\Operation\\' . 'Operation' . ucfirst($operationName) . 'Type';
    }
}
