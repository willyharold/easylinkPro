<?php

namespace App\Controller;

use App\Entity\ArticleBlog;
use App\Form\ArticleBlogType;
use App\Repository\ArticleBlogRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/article/blog")
 */
class ArticleBlogController extends Controller
{
    /**
     * @Route("/", name="article_blog_index", methods={"GET"})
     */
    public function index(ArticleBlogRepository $articleBlogRepository): Response
    {
        return $this->render('article_blog/index.html.twig', [
            'article_blogs' => $articleBlogRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="article_blog_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $articleBlog = new ArticleBlog();
        $form = $this->createForm(ArticleBlogType::class, $articleBlog);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($articleBlog);
            $entityManager->flush();

            return $this->redirectToRoute('article_blog_index');
        }

        return $this->render('article_blog/new.html.twig', [
            'article_blog' => $articleBlog,
            'form' => $form->createView(),
            'type' => "Ajouter",
        ]);
    }

    /**
     * @Route("/{id}", name="article_blog_show", methods={"GET"})
     */
    public function show(ArticleBlog $articleBlog): Response
    {
        return $this->render('article_blog/show.html.twig', [
            'article_blog' => $articleBlog,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="article_blog_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, ArticleBlog $articleBlog): Response
    {
        $article2 = $articleBlog;
        $form = $this->createForm(ArticleBlogType::class, $articleBlog);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if($articleBlog->getAvatar()==null)
            {
                if($article2->getAvatar()==null)
                {
                    $articleBlog->setAvatar($article2->getAvatar());
                }
                
            }
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('article_blog_index');
        }

        return $this->render('article_blog/new.html.twig', [
            'article_blog' => $articleBlog,
            'form' => $form->createView(),
            'type' => "Modifier",
        ]);
    }

    /**
     * @Route("/{id}", name="article_blog_delete", methods={"DELETE"})
     */
    public function delete(Request $request, ArticleBlog $articleBlog): Response
    {
        if ($this->isCsrfTokenValid('delete'.$articleBlog->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($articleBlog);
            $entityManager->flush();
        }

        return $this->redirectToRoute('article_blog_index');
    }
}
