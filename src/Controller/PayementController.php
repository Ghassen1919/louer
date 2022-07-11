<?php

namespace App\Controller;

use App\Entity\Payement;
use App\Form\PayementType;
use App\Repository\PayementRepository;
use App\Repository\MaisonRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use MercurySeries\FlashyBundle\FlashyNotifier;


/**
 * @Route("/payement")
 */
class PayementController extends AbstractController
{
    /**
     * @Route("/", name="app_payement_index", methods={"GET"})
     */
    public function index(PayementRepository $payementRepository): Response
    {
        return $this->render('payement/index.html.twig', [
            'payements' => $payementRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="app_payement_new", methods={"GET", "POST"})
     */
    public function new(Request $request, PayementRepository $payementRepository): Response
    {
        $payement = new Payement();
        $form = $this->createForm(PayementType::class, $payement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $payementRepository->add($payement, true);

            return $this->redirectToRoute('app_payement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('payement/new.html.twig', [
            'payement' => $payement,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_payement_show", methods={"GET"})
     */
    public function show(Payement $payement): Response
    {
        return $this->render('payement/show.html.twig', [
            'payement' => $payement,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_payement_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, FlashyNotifier $flashy, MaisonRepository $maisonRepository, $id, Payement $payement, PayementRepository $payementRepository): Response
    {
        $maison = $maisonRepository->find($id);
        $form = $this->createForm(PayementType::class, $payement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $payementRepository->add($payement, true);
            $flashy->muted('payement modifié avec succée!', '#');
            return $this->redirectToRoute('app_maison_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('payement/edit.html.twig', [
            'maison' => $maison,
            'payement' => $payement,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_payement_delete", methods={"POST"})
     */
    public function delete(Request $request, Payement $payement, FlashyNotifier $flashy, PayementRepository $payementRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $payement->getId(), $request->request->get('_token'))) {
            $payementRepository->remove($payement, true);
        }
        $flashy->error('payement supprimé avec succée!', '#');
        return $this->redirectToRoute('app_payement_index', [], Response::HTTP_SEE_OTHER);
    }
}
