<?php

namespace App\Controller;

use App\Entity\Maison;
use App\Entity\Payement;
use App\Form\MaisonType;
use App\Form\PayementType;
use App\Repository\MaisonRepository;
use App\Repository\PayementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use MercurySeries\FlashyBundle\FlashyNotifier;


/**
 * @Route("/maison")
 */
class MaisonController extends AbstractController
{

    /**
     * @Route("/", name="app_maison_index", methods={"GET"})
     */
    public function index(MaisonRepository $maisonRepository): Response
    {
        $maison = $maisonRepository->findAll();
        $nbrprest = 0.0;
        foreach ($maison as $maison) {

            $nbrprest += 1;
        }

        $maison = $maisonRepository->findAll();

        $gain = 0;
        foreach ($maison as $maison) {
            $gain += $maison->getPrix() * 12;
        }
        return $this->render('maison/index.html.twig', [
            'maisons' => $maisonRepository->findAll(), 'nbrprest' => $nbrprest, 'gain' => $gain
        ]);
    }

    /**
     * @Route("/new", name="app_maison_new", methods={"GET", "POST"})
     */
    public function new(Request $request, MaisonRepository $maisonRepository, FlashyNotifier $flashy): Response
    {
        $maison = new Maison();
        $form = $this->createForm(MaisonType::class, $maison);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $maisonRepository->add($maison, true);
            $flashy->success('immobilier Crée avec succée!', '#');

            return $this->redirectToRoute('app_maison_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('maison/new.html.twig', [
            'maison' => $maison,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_maison_show", methods={"GET"})
     */
    public function show(Maison $maison): Response
    {
        return $this->render('maison/show.html.twig', [
            'maison' => $maison,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="app_maison_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Maison $maison, MaisonRepository $maisonRepository, FlashyNotifier $flashy): Response
    {
        $form = $this->createForm(MaisonType::class, $maison);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $maisonRepository->add($maison, true);
            $flashy->muted('immobilier modifié avec succée!', '#');
            return $this->redirectToRoute('app_maison_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('maison/edit.html.twig', [
            'maison' => $maison,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="app_maison_delete", methods={"POST"})
     */
    public function delete(Request $request, Maison $maison, MaisonRepository $maisonRepository, FlashyNotifier $flashy): Response
    {
        if ($this->isCsrfTokenValid('delete' . $maison->getId(), $request->request->get('_token'))) {
            $maisonRepository->remove($maison, true);
        }
        $flashy->error('immobilier supprimé avec succée!', '#');
        return $this->redirectToRoute('app_maison_index', [], Response::HTTP_SEE_OTHER);
    }
    /**
     * @Route("/payement/{id}", name="app_postcom")
     */

    public function PackItem(Request $request, MaisonRepository $maisonRepository, $id, PayementRepository $payementRepository): Response
    {
        $maison = $maisonRepository->find($id);
        $payement = $payementRepository->getPostcom($id);

        $nbrprest = 0.0;
        foreach ($payement as $payement) {

            $nbrprest += 1;
        }



        $payement = $payementRepository->getPostcom($id);
        $a = 0;
        foreach ($payement as $payement) {
            if ($payement->getPaye() == "payé")
                $a += 1;
        }



        $payement = $payementRepository->getPostcom($id);
        return $this->render('maison/packItem.html.twig', [

            'maison' => $maison,
            'payements' => $payement,
            'nbrprest' => $nbrprest,
            'a' => $a,



        ]);
    }
    /**
     * @Route("/payement/{id}/new", name="app_postcom1", methods={"GET", "POST"}, requirements={"id":"\d+"})
     */

    public function PackItem1(Request $request, FlashyNotifier $flashy, MaisonRepository $maisonRepository, $id, PayementRepository $payementRepository): Response
    {
        $maison = $maisonRepository->find($id);
        $payement = $payementRepository->getPostcom($id);


        $newPayement = new Payement();
        $form = $this->createForm(PayementType::class, $newPayement);

        $form->handleRequest($request);
        $newPayement->setMaison($maison);
        if ($form->isSubmitted() && $form->isValid()) {

            $payementRepository->add($newPayement, true);
            $newPayement->setMaison($maison);
            $flashy->success('payement Crée avec succée!', '#');
            return $this->redirectToRoute('app_postcom', [
                'id' => $maison->getId()
            ], Response::HTTP_SEE_OTHER);
        }

        return $this->render('maison/new1.html.twig', [

            'maison' => $maison,
            'payements' => $payement,

            'form' => $form->createView(),
        ]);
    }
    
}
