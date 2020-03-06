<?php

namespace App\Controller;

use App\Entity\Debt;
use App\Entity\Operation;
use App\Enum\OperationTypeEnum;
use App\Form\DebtType;
use App\Repository\DebtRepository;
use App\Service\DebtMonitor;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class DebtController
 * @package App\Controller
 *
 * @Route("/debt")
 */
class DebtController extends AbstractController
{
    /** @var DebtMonitor */
    private $debtMonitor;

    /** @var EntityManagerInterface */
    private $em;

    /** @var DebtRepository */
    private $debtRepo;

    /**
     * DebtController constructor.
     *
     * @param DebtMonitor            $debtMonitor
     * @param EntityManagerInterface $em
     */
    public function __construct(DebtMonitor $debtMonitor, EntityManagerInterface $em)
    {
        $this->debtMonitor = $debtMonitor;
        $this->em          = $em;
        $this->debtRepo    = $em->getRepository(Debt::class);
    }

    /**
     * @Route("/", name="debt_index")
     */
    public function index(): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $user  = $this->getUser();
        $debts = $this->debtRepo->findByUser($user);

        return $this->render('debt/index.html.twig', [
            'debts' => $debts,
        ]);
    }

    /**
     * @Route("/new", name="debt_new", methods={"GET", "POST"})
     *
     * @param Request $request
     *
     * @return Response
     */
    public function new(Request $request): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        /** @var UserInterface $user */
        $user = $this->getUser();

        $debt = new Debt();
        $debt->setUser($user);

        $form = $this->createForm(DebtType::class, $debt);
        $form->get('date')->setData(new \DateTime());
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Debt $debt */
            $debt = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($debt);


            $operation = new Operation();
            $date   = $form->get('date')->getData();
            $person = $form->get('person')->getData();
            $target = $form->get('target')->getData();
            $amount = $form->get('amount')->getData();
            $operation->setUser($user);
            $operation->setType(OperationTypeEnum::TYPE_DEBT);
            $operation->setDate($date);
            $operation->setPerson($person);
            $operation->setTarget($target);
            $operation->setAmount($amount);

            // TODO add validation before persising

            $em->persist($operation);







            $em->flush();

            return $this->redirectToRoute('debt_index');
        }

        return $this->render('debt/new.html.twig', [
            'debtForm' => $form->createView(),
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

            $em = $this->getDoctrine()->getManager();
            $em->persist($debt);
            $em->flush();

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

        $em = $this->getDoctrine()->getManager();
        $em->remove($debt);
        $em->flush();

        return new JsonResponse([       // TODO fix it
            'data' => 'Debt deleted successfully',
        ]);
    }
}
