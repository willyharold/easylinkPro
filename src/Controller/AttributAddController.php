<?php

namespace App\Controller;

use App\Entity\AttributAdd;
use App\Form\AttributAddType;
use App\Repository\AttributAddRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/attribut/add")
 */
class AttributAddController extends Controller
{
    /**
     * @Route("/", name="attribut_add_index", methods={"GET"})
     */
    public function index(AttributAddRepository $attributAddRepository): Response
    {
        return $this->render('attribut_add/index.html.twig', [
            'attribut_adds' => $attributAddRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="attribut_add_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $attributAdd = new AttributAdd();
        $form = $this->createForm(AttributAddType::class, $attributAdd);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($attributAdd);
            $entityManager->flush();

            return $this->redirectToRoute('attribut_add_index');
        }

        return $this->render('attribut_add/new.html.twig', [
            'attribut_add' => $attributAdd,
            'form' => $form->createView(),
            'type' => "Ajouter",
        ]);
    }

    /**
     * @Route("/{id}", name="attribut_add_show", methods={"GET"})
     */
    public function show(AttributAdd $attributAdd): Response
    {
        return $this->render('attribut_add/show.html.twig', [
            'attribut_add' => $attributAdd,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="attribut_add_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, AttributAdd $attributAdd): Response
    {
        $form = $this->createForm(AttributAddType::class, $attributAdd);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('attribut_add_index');
        }

        return $this->render('attribut_add/new.html.twig', [
            'attribut_add' => $attributAdd,
            'form' => $form->createView(),
            'type' => "Modifier",
        ]);
    }

    /**
     * @Route("/{id}", name="attribut_add_delete", methods={"DELETE"})
     */
    public function delete(Request $request, AttributAdd $attributAdd): Response
    {
        if ($this->isCsrfTokenValid('delete'.$attributAdd->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($attributAdd);
            $entityManager->flush();
        }

        return $this->redirectToRoute('attribut_add_index');
    }
}
