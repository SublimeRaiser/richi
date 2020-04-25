<?php

namespace App\Controller;

use App\Entity\Obligation\Debt;
use App\Entity\Operation\OperationDebt;
use App\Form\DebtType;
use App\Repository\Obligation\DebtRepository;
use App\Service\DebtMonitor;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class DebtController
 * @package App\Controller
 *
 * @Route("/debt")
 */
class DebtController extends AbstractController
{
    /** @var EntityManagerInterface */
    private $em;

    /** @var DebtRepository */
    private $debtRepo;

    /** @var ValidatorInterface */
    private $validator;

    /** @var DebtMonitor */
    private $debtMonitor;

    /**
     * DebtController constructor.
     *
     * @param EntityManagerInterface $em
     * @param ValidatorInterface     $validator
     * @param DebtMonitor            $debtMonitor
     */
    public function __construct(EntityManagerInterface $em, ValidatorInterface $validator, DebtMonitor $debtMonitor)
    {
        $this->em          = $em;
        $this->debtRepo    = $em->getRepository(Debt::class);
        $this->validator   = $validator;
        $this->debtMonitor = $debtMonitor;
    }

    /**
     * @Route("/", name="debt_index", methods={"GET"})
     */
    public function index(): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $user          = $this->getUser();
        $debtSummaries = $this->debtMonitor->getDebtSummaries($user);

        return $this->render('debt/index.html.twig', [
            'debtSummaries' => $debtSummaries,
        ]);
    }

    /**
     * @Route("/new", name="debt_new", methods={"GET", "POST"})
     *
     * @param Request $request
     *
     * @return Response
     *
     * @throws Exception
     */
    public function new(Request $request): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        /** @var UserInterface $user */
        $user = $this->getUser();

        $debt = new Debt();
        $debt->setUser($user);

        $form = $this->createForm(DebtType::class, $debt);
        $form->get('date')->setData(new DateTime());
        $form->handleRequest($request);

        $operationErrors = [];
        if ($form->isSubmitted()) {
            // Create instance for related debt operation
            $operationDebt = new OperationDebt();
            $date          = $form->get('date')->getData();
            $target        = $form->get('target')->getData();
            $amount        = $form->get('amount')->getData();
            $operationDebt->setDate($date);
            $operationDebt->setTarget($target);
            $operationDebt->setAmount($amount);
            $operationDebt->setDebt($debt);
            $operationDebt->setUser($user);
            $operationErrors = $this->validator->validate($operationDebt);

            if ($form->isValid() && count($operationErrors) == 0) {
                $debt = $form->getData();
                $em   = $this->em;
                $em->transactional(function ($em) use ($debt, $operationDebt) {
                    /** @var EntityManagerInterface $em */
                    $em->persist($debt);
                    $em->persist($operationDebt);
                    $em->flush();
                });

                return $this->redirectToRoute('debt_index');
            }
        }

        return $this->render('debt/new.html.twig', [
            'debtForm'        => $form->createView(),
            'operationErrors' => $operationErrors,
        ]);
    }

    /**
     * @Route("/edit/{id}", name="debt_edit", methods={"GET", "POST"})
     *
     * @param Debt    $debt
     * @param Request $request
     *
     * @return Response
     */
    public function edit(Debt $debt, Request $request): Response
    {
        $this->denyAccessUnlessGranted('DEBT_EDIT', $debt);

        $form = $this->createForm(DebtType::class, $debt);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Debt $debt */
            $debt = $form->getData();

            $this->em->persist($debt);
            $this->em->flush();

            return $this->redirectToRoute('debt_index');
        }

        return $this->render('debt/edit.html.twig', [
            'debtForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="debt_delete", methods={"DELETE"})
     *
     * @param Debt $debt
     *
     * @return Response
     */
    public function delete(Debt $debt): Response
    {
        $this->denyAccessUnlessGranted('DEBT_DELETE', $debt);

        $this->em->remove($debt);
        $this->em->flush();

        return new JsonResponse([       // TODO fix it
            'data' => 'Debt deleted successfully',
        ]);
    }
}
