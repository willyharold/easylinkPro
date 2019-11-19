<?php

namespace App\Controller\Admin;

use App\Entity\AffectationConfirme;
use App\Form\AffectationConfirmeType;
use App\Repository\AffectationConfirmeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/affectation/confirme")
 */
class AffectationConfirmeController extends Controller
{
    /**
     * @Route("/", name="affectation_confirme_index", methods={"GET"})
     */
    public function index(AffectationConfirmeRepository $affectationConfirmeRepository): Response
    {
        return $this->render('affectation_confirme/index.html.twig', [
            'affectation_confirmes' => $affectationConfirmeRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="affectation_confirme_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $affectationConfirme = new AffectationConfirme();
        $form = $this->createForm(AffectationConfirmeType::class, $affectationConfirme);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($affectationConfirme);
            $entityManager->flush();

            return $this->redirectToRoute('affectation_confirme_index');
        }

        return $this->render('affectation_confirme/new.html.twig', [
            'affectation_confirme' => $affectationConfirme,
            'form' => $form->createView(),
            'type' => "Ajouter",
        ]);
    }

    /**
     * @Route("/{id}", name="affectation_confirme_show", methods={"GET"})
     */
    public function show(AffectationConfirme $affectationConfirme): Response
    {
        return $this->render('affectation_confirme/show.html.twig', [
            'affectation_confirme' => $affectationConfirme,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="affectation_confirme_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, AffectationConfirme $affectationConfirme): Response
    {
        $form = $this->createForm(AffectationConfirmeType::class, $affectationConfirme);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('affectation_confirme_index');
        }

        return $this->render('affectation_confirme/new.html.twig', [
            'affectation_confirme' => $affectationConfirme,
            'form' => $form->createView(),
            'type' => "Modifier",
        ]);
    }

    /**
     * @Route("/{id}", name="affectation_confirme_delete", methods={"DELETE"})
     */
    public function delete(Request $request, AffectationConfirme $affectationConfirme): Response
    {
        if ($this->isCsrfTokenValid('delete'.$affectationConfirme->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($affectationConfirme);
            $entityManager->flush();
        }

        return $this->redirectToRoute('affectation_confirme_index');
    }
}
