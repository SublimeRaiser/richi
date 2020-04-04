<?php

namespace App\Controller;

use App\Entity\Category\BaseCategory;
use App\Entity\Category\CategoryExpense;
use App\Entity\Category\CategoryIncome;
use App\Repository\Category\BaseCategoryRepository;
use App\Repository\Category\CategoryExpenseRepository;
use App\Repository\Category\CategoryIncomeRepository;
use App\Service\OperationNameFormatter;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @Route("/category")
 */
class CategoryController extends AbstractController
{
    /** @var EntityManagerInterface */
    private $em;

    /** @var OperationNameFormatter */
    private $operationNameFormatter;

    /**
     * CategoryController constructor.
     *
     * @param EntityManagerInterface $em
     * @param OperationNameFormatter $operationNameFormatter
     */
    public function __construct(EntityManagerInterface $em, OperationNameFormatter $operationNameFormatter)
    {
        $this->em                     = $em;
        $this->operationNameFormatter = $operationNameFormatter;
    }

    /**
     * @Route("/", name="category_index", methods={"GET"})
     *
     * @return Response
     */
    public function index(): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $user = $this->getUser();

        /** @var CategoryIncomeRepository $incomeCategoryRepo */
        $incomeCategoryRepo  = $this->getDoctrine()->getRepository(CategoryIncome::class);
        $incomeCategories    = $incomeCategoryRepo->findByUser($user);
        /** @var CategoryExpenseRepository $expenseCategoryRepo */
        $expenseCategoryRepo = $this->getDoctrine()->getRepository(CategoryExpense::class);
        $expenseCategories   = $expenseCategoryRepo->findByUser($user);

        return $this->render('category/index.html.twig', [
            'incomeCategories'  => $incomeCategories,
            'expenseCategories' => $expenseCategories,
        ]);
    }

    /**
     * @Route("/new/{operationSlug}", name="category_new", methods={"GET", "POST"})
     *
     * @param string  operationName
     * @param Request $request
     *
     * @return Response
     */
    public function new(string $operationSlug, Request $request): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $operationType = $this->operationNameFormatter->getTypeBySlug($operationSlug);
        $this->validateOperationType($operationType);

        $categoryClassName = $this->getCategoryClassName($operationType);
        /** @var BaseCategory $category */
        $category = new $categoryClassName();
        /** @var UserInterface $user */
        $user = $this->getUser();
        $category->setUser($user);

        $formClassName = $this->getFormClassName($operationType);
        $form          = $this->createForm($formClassName, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var BaseCategory $category */
            $category = $form->getData();

            $this->em->persist($category);
            $this->em->flush();

            return $this->redirectToRoute('category_index');
        }

        return $this->render('category/new.html.twig', [
            'categoryForm'  => $form->createView(),
            'operationName' => $this->operationNameFormatter->getNameBySlug($operationSlug),
        ]);
    }

    /**
     * @Route("/edit/{operationSlug}/{id}", name="category_edit", methods={"GET", "POST"})
     *
     * @param string   operationName
     * @param integer  $id
     * @param Request  $request
     *
     * @return Response
     */
    public function edit(string $operationSlug, int $id, Request $request): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $operationType = $this->operationNameFormatter->getTypeBySlug($operationSlug);
        $this->validateOperationType($operationType);

        /** @var BaseCategory $category */
        $category = $this->findCategory($operationType, $id);
        $this->denyAccessUnlessGranted('CATEGORY_EDIT', $category);

        $formClassName = $this->getFormClassName($operationType);
        $form          = $this->createForm($formClassName, $category);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $category = $form->getData();

            $this->em->persist($category);
            $this->em->flush();

            return $this->redirectToRoute('category_index');
        }

        return $this->render('category/edit.html.twig', [
            'categoryForm'  => $form->createView(),
            'operationName' => $this->operationNameFormatter->getNameBySlug($operationSlug),
            'operationSlug' => $operationSlug,
            'parentName'    => $category->getParent() ? $category->getParent()->getName() : null,
        ]);
    }

    /**
     * @Route("/{operationSlug}/{id}", name="category_delete", methods={"DELETE"})
     *
     * @param string  operationName
     * @param integer $id
     *
     * @return Response
     */
    public function delete(string $operationSlug, int $id): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $operationType = $this->operationNameFormatter->getTypeBySlug($operationSlug);
        $this->validateOperationType($operationType);

        $category = $this->findCategory($operationType, $id);
        $this->denyAccessUnlessGranted('CATEGORY_DELETE', $category);

        $this->em->remove($category);
        $this->em->flush();

        return new JsonResponse([       // TODO fix it
            'data' => 'Category deleted successfully',
        ]);
    }

    /**
     * Returns category with the given ID for the provided operation type.
     *
     * @param integer|null $operationType
     * @param integer      $id
     *
     * @return BaseCategory
     *
     * @throws NotFoundHttpException If category was not found
     */
    private function findCategory(?int $operationType, int $id): BaseCategory
    {
        $categoryClassName = $this->getCategoryClassName($operationType);
        /** @var BaseCategoryRepository $categoryRepo */
        $categoryRepo      = $this->getDoctrine()->getRepository($categoryClassName);
        /** @var BaseCategory|null $category */
        $category          = $categoryRepo->find($id);
        if (!$category) {
            $operationNameCamelCase = $this->operationNameFormatter->getCamelCaseByType($operationType);
            throw $this->createNotFoundException($operationNameCamelCase . ' category not found.');
        }

        return $category;
    }

    /**
     * Returns category class name for the provided operation type.
     *
     * @param integer|null $operationType
     *
     * @return string|null
     */
    private function getCategoryClassName(?int $operationType): ?string
    {
        $categoryClassName      = null;
        $operationNameCamelCase = null;
        if ($operationType) {
            $operationNameCamelCase = $this->operationNameFormatter->getCamelCaseByType($operationType);
        }
        if ($operationNameCamelCase) {
            $categoryClassName = 'App\\Entity\\Category\\' . 'Category'. $operationNameCamelCase;
        }

        return $categoryClassName;
    }

    /**
     * Returns class name for a category form type depending on the operation type.
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
            $formClassName = 'App\\Form\\Category\\' . 'Category' . $operationNameCamelCase . 'Type';
        }

        return $formClassName;
    }

    /**
     * Throws an exception if a category class for the operation type does not exist.
     *
     * @param integer|null $operationType
     *
     * @throws BadRequestHttpException If the provided operation type is not supported for a categories.
     */
    private function validateOperationType(?int $operationType): void
    {
        $categoryClassName = $this->getCategoryClassName($operationType);
        if (!class_exists($categoryClassName)) {
            throw new BadRequestHttpException('Unsupported operation type for a categories.');
        }
    }
}
