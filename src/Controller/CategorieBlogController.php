<?php

namespace App\Controller;

use App\Entity\CategorieBlog;
use App\Form\CategorieBlogType;
use App\Repository\CategorieBlogRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/categorie/blog")
 */
class CategorieBlogController extends Controller
{
    /**
     * @Route("/", name="categorie_blog_index", methods={"GET"})
     */
    public function index(CategorieBlogRepository $categorieBlogRepository): Response
    {
        return $this->render('categorie_blog/index.html.twig', [
            'categorie_blogs' => $categorieBlogRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="categorie_blog_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $categorieBlog = new CategorieBlog();
        $form = $this->createForm(CategorieBlogType::class, $categorieBlog);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($categorieBlog);
            $entityManager->flush();

            return $this->redirectToRoute('categorie_blog_index');
        }

        return $this->render('categorie_blog/new.html.twig', [
            'categorie_blog' => $categorieBlog,
            'form' => $form->createView(),
            'type' => "Ajouter",
        ]);
    }

    /**
     * @Route("/{id}", name="categorie_blog_show", methods={"GET"})
     */
    public function show(CategorieBlog $categorieBlog): Response
    {
        return $this->render('categorie_blog/show.html.twig', [
            'categorie_blog' => $categorieBlog,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="categorie_blog_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, CategorieBlog $categorieBlog): Response
    {
        $form = $this->createForm(CategorieBlogType::class, $categorieBlog);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('categorie_blog_index');
        }

        return $this->render('categorie_blog/new.html.twig', [
            'categorie_blog' => $categorieBlog,
            'form' => $form->createView(),
            'type' => "Modifier",
        ]);
    }

    /**
     * @Route("/{id}", name="categorie_blog_delete", methods={"DELETE"})
     */
    public function delete(Request $request, CategorieBlog $categorieBlog): Response
    {
        if ($this->isCsrfTokenValid('delete'.$categorieBlog->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($categorieBlog);
            $entityManager->flush();
        }

        return $this->redirectToRoute('categorie_blog_index');
    }
}
