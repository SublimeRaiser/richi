<?php

namespace App\Controller;

use App\Entity\Debt;
use App\Form\DebtType;
use App\Service\DebtMonitor;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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

    /**
     * DebtController constructor.
     *
     * @param DebtMonitor $debtMonitor
     */
    public function __construct(DebtMonitor $debtMonitor)
    {
        $this->debtMonitor = $debtMonitor;
    }

    /**
     * @Route("/", name="debt_index")
     */
    public function index(): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $user = $this->getUser();

        return $this->render('debt/index.html.twig', [
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

        $form    = $this->createForm(DebtType::class, $debt);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var Debt $debt */
            $debt = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($debt);
            $em->flush();

            return $this->redirectToRoute('debt_index');
        }

        return $this->render('debt/new.html.twig', [
            'debtForm' => $form->createView(),
        ]);
    }
}
