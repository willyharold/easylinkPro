<?php

namespace App\Controller;

use App\Entity\AttributAddRep;
use App\Form\AttributAddRepType;
use App\Repository\AttributAddRepRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/attribut/add/rep")
 */
class AttributAddRepController extends Controller
{
    /**
     * @Route("/", name="attribut_add_rep_index", methods={"GET"})
     */
    public function index(AttributAddRepRepository $attributAddRepRepository): Response
    {
        return $this->render('attribut_add_rep/index.html.twig', [
            'attribut_add_reps' => $attributAddRepRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="attribut_add_rep_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $attributAddRep = new AttributAddRep();
        $form = $this->createForm(AttributAddRepType::class, $attributAddRep);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($attributAddRep);
            $entityManager->flush();

            return $this->redirectToRoute('attribut_add_rep_index');
        }

        return $this->render('attribut_add_rep/new.html.twig', [
            'attribut_add_rep' => $attributAddRep,
            'form' => $form->createView(),
            'type' => "Ajouter",
        ]);
    }

    /**
     * @Route("/{id}", name="attribut_add_rep_show", methods={"GET"})
     */
    public function show(AttributAddRep $attributAddRep): Response
    {
        return $this->render('attribut_add_rep/show.html.twig', [
            'attribut_add_rep' => $attributAddRep,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="attribut_add_rep_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, AttributAddRep $attributAddRep): Response
    {
        $form = $this->createForm(AttributAddRepType::class, $attributAddRep);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('attribut_add_rep_index');
        }

        return $this->render('attribut_add_rep/new.html.twig', [
            'attribut_add_rep' => $attributAddRep,
            'form' => $form->createView(),
            'type' => "Modifier",
        ]);
    }

    /**
     * @Route("/{id}", name="attribut_add_rep_delete", methods={"DELETE"})
     */
    public function delete(Request $request, AttributAddRep $attributAddRep): Response
    {
        if ($this->isCsrfTokenValid('delete'.$attributAddRep->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($attributAddRep);
            $entityManager->flush();
        }

        return $this->redirectToRoute('attribut_add_rep_index');
    }
}
