<?php

namespace App\Controller;

use App\Entity\SousSpecialite;
use App\Form\SousSpecialiteType;
use App\Repository\SousSpecialiteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/sous/specialite")
 */
class SousSpecialiteController extends Controller
{
    /**
     * @Route("/", name="sous_specialite_index", methods={"GET"})
     */
    public function index(SousSpecialiteRepository $sousSpecialiteRepository): Response
    {
        return $this->render('sous_specialite/index.html.twig', [
            'sous_specialites' => $sousSpecialiteRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="sous_specialite_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $sousSpecialite = new SousSpecialite();
        $form = $this->createForm(SousSpecialiteType::class, $sousSpecialite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($sousSpecialite);
            $entityManager->flush();

            return $this->redirectToRoute('sous_specialite_index');
        }

        return $this->render('sous_specialite/new.html.twig', [
            'sous_specialite' => $sousSpecialite,
            'form' => $form->createView(),
            'type' => "Ajouter",
        ]);
    }

    /**
     * @Route("/{id}", name="sous_specialite_show", methods={"GET"})
     */
    public function show(SousSpecialite $sousSpecialite): Response
    {
        return $this->render('sous_specialite/show.html.twig', [
            'sous_specialite' => $sousSpecialite,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="sous_specialite_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, SousSpecialite $sousSpecialite): Response
    {
        $form = $this->createForm(SousSpecialiteType::class, $sousSpecialite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('sous_specialite_index');
        }

        return $this->render('sous_specialite/new.html.twig', [
            'sous_specialite' => $sousSpecialite,
            'form' => $form->createView(),
            'type' => "Modifier",
        ]);
    }

    /**
     * @Route("/{id}", name="sous_specialite_delete", methods={"DELETE"})
     */
    public function delete(Request $request, SousSpecialite $sousSpecialite): Response
    {
        if ($this->isCsrfTokenValid('delete'.$sousSpecialite->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($sousSpecialite);
            $entityManager->flush();
        }

        return $this->redirectToRoute('sous_specialite_index');
    }
}
