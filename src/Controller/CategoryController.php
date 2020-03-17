<?php

namespace App\Controller;

use App\Entity\Category\BaseCategory;
use App\Entity\Category\ExpenseCategory;
use App\Entity\Category\IncomeCategory;
use App\Enum\OperationTypeEnum;
use App\Repository\Category\BaseCategoryRepository;
use App\Repository\Category\ExpenseCategoryRepository;
use App\Repository\Category\IncomeCategoryRepository;
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
 * Class CategoryController
 * @package App\Controller
 *
 * @Route("/category")
 */
class CategoryController extends AbstractController
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * CategoryController constructor.
     *
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
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
        $this->checkOperationName($operationName);

        /** @var UserInterface $user */
        $user = $this->getUser();

        $categoryClassName = $this->getClassNameByOperationName($operationName);
        /** @var BaseCategory $category */
        $category = new $categoryClassName();
        $category->setUser($user);

        $typeName = $this->getTypeNameByOperationName($operationName);
        $form     = $this->createForm($typeName, $category);
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
            'operationName' => $operationName,
        ]);
    }

    /**
     * @Route("/edit/{operationName}/{id}", name="category_edit", methods={"GET", "POST"})
     *
     * @param string   operationName
     * @param integer  $id
     * @param Request  $request
     *
     * @return Response
     */
    public function edit(string $operationName, int $id, Request $request): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        $this->checkOperationName($operationName);

        $category = $this->findCategory($operationName, $id);
        $this->denyAccessUnlessGranted('CATEGORY_EDIT', $category);

        $typeName = $this->getTypeNameByOperationName($operationName);
        $form     = $this->createForm($typeName, $category);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $category = $form->getData();

            $this->em->persist($category);
            $this->em->flush();

            return $this->redirectToRoute('category_index');
        }

        return $this->render('category/edit.html.twig', [
            'categoryForm'  => $form->createView(),
            'operationName' => $operationName,
            'parentName'    => $category->getParent() ? $category->getParent()->getName() : null,
        ]);
    }

    /**
     * @Route("/{operationName}/{id}", name="category_delete", methods={"DELETE"})
     *
     * @param string  operationName
     * @param integer $id
     *
     * @return Response
     */
    public function delete(string $operationName, int $id): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');
        $this->checkOperationName($operationName);

        $category = $this->findCategory($operationName, $id);
        $this->denyAccessUnlessGranted('CATEGORY_DELETE', $category);

        $this->em->remove($category);
        $this->em->flush();

        return new JsonResponse([       // TODO fix it
            'data' => 'Category deleted successfully',
        ]);
    }

    /**
     * Throws the exception if provided operation name is not supported.
     *
     * @param string $operationName
     *
     * @return void
     */
    private function checkOperationName(string $operationName): void
    {
        if (!OperationTypeEnum::isTypeExists($operationName)) {
            throw new BadRequestHttpException('Unsupported operation name provided.');
        }
    }

    /**
     * Returns category with the given ID for provided operation name.
     *
     * @param string  $operationName
     * @param integer $id
     *
     * @return BaseCategory
     *
     * @throws NotFoundHttpException If category was not found
     */
    private function findCategory(string $operationName, int $id): BaseCategory
    {
        $categoryClassName = $this->getClassNameByOperationName($operationName);
        /** @var BaseCategoryRepository $categoryRepo */
        $categoryRepo = $this->getDoctrine()->getRepository($categoryClassName);
        /** @var BaseCategory|null $category */
        $category = $categoryRepo->find($id);
        if (!$category) {
            throw $this->createNotFoundException(ucfirst($operationName) . ' category not found.');
        }

        return $category;
    }

    /**
     * Returns class name for a category depending on the operation name.
     *
     * @param string $operationName
     *
     * @return string
     */
    private function getClassNameByOperationName(string $operationName): string
    {
        return 'App\\Entity\\Category\\' . ucfirst($operationName) . 'Category';
    }

    /**
     * Returns class name for a category form type depending on the operation name.
     *
     * @param string $operationName
     *
     * @return string
     */
    private function getTypeNameByOperationName(string $operationName): string
    {
        return 'App\\Form\\Category\\' . ucfirst($operationName) . 'CategoryType';
    }
}
