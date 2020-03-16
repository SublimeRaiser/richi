<?php

namespace App\Controller;

use App\Entity\Category\BaseCategory;
use App\Entity\Category\ExpenseCategory;
use App\Entity\Category\IncomeCategory;
use App\Enum\OperationTypeEnum;
use App\Form\Category\IncomeCategoryType;
use App\Form\Category\ExpenseCategoryType;
use App\Repository\Category\ExpenseCategoryRepository;
use App\Repository\Category\IncomeCategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Form;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class CategoryController
 * @package App\Controller
 *
 * @Route("/category")
 */
class CategoryController extends AbstractController
{
    /**
     * @Route("/", name="category_index", methods={"GET"})
     *
     * @return Response
     */
    public function index(): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $user = $this->getUser();

        /** @var IncomeCategoryRepository $incomeCategoryRepo */
        $incomeCategoryRepo  = $this->getDoctrine()->getRepository(IncomeCategory::class);
        $incomeCategories    = $incomeCategoryRepo->findByUser($user);
        /** @var ExpenseCategoryRepository $expenseCategoryRepo */
        $expenseCategoryRepo = $this->getDoctrine()->getRepository(ExpenseCategory::class);
        $expenseCategories   = $expenseCategoryRepo->findByUser($user);

        return $this->render('category/index.html.twig', [
            'incomeCategories'  => $incomeCategories,
            'expenseCategories' => $expenseCategories,
        ]);
    }

    /**
     * @Route("/new/{operationName}", name="category_new", methods={"GET", "POST"})
     *
     * @param string  operationName
     * @param Request $request
     *
     * @return Response
     */
    public function new(string $operationName, Request $request): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        if (!OperationTypeEnum::isTypeExists($operationName)) {
            throw new BadRequestHttpException('Unsupported operation type.');
        }

        /** @var UserInterface $user */
        $user = $this->getUser();

        $categoryClassName = 'App\\Entity\\Category\\'.ucfirst($operationName).'Category';
        /** @var BaseCategory $category */
        $category = new $categoryClassName();
        $category->setUser($user);

        /** @var Form $form */
        $categoryTypeClassName = 'App\\Form\\Category\\'.ucfirst($operationName).'CategoryType';
        $form = $this->createForm($categoryTypeClassName, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            /** @var BaseCategory $category */
            $category = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();

            return $this->redirectToRoute('category_index');
        }

        return $this->render('category/new.html.twig', [
            'categoryForm'  => $form->createView(),
            'operationName' => $operationName,
        ]);
    }

    /**
     * @Route("/edit/{id}", name="category_edit", methods={"GET", "POST"})
     *
     * @param IncomeCategory $category
     * @param Request  $request
     *
     * @return Response
     */
    public function edit(IncomeCategory $category, Request $request): Response
    {
        $this->denyAccessUnlessGranted('CATEGORY_EDIT', $category);

        $form = $this->createForm(CategoryType::class, $category, [
            'operation_type' => $category->getOperationType(),
        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $category = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();

            return $this->redirectToRoute('category_index');
        }

        $operationName = OperationTypeEnum::getTypeName($category->getOperationType());

        return $this->render('category/edit.html.twig', [
            'categoryForm'  => $form->createView(),
            'operationName' => $operationName,
            'parentName'    => $category->getParent() ? $category->getParent()->getName() : null,
        ]);
    }

    /**
     * @Route("/{id}", name="category_delete", methods={"DELETE"})
     *
     * @param IncomeCategory $category
     *
     * @return Response
     */
    public function delete(IncomeCategory $category): Response
    {
        $this->denyAccessUnlessGranted('CATEGORY_DELETE', $category);

        $em = $this->getDoctrine()->getManager();
        $em->remove($category);
        $em->flush();

        return new JsonResponse([       // TODO fix it
            'data' => 'Category deleted successfully',
        ]);
    }
}
