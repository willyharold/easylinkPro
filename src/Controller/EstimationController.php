<?php

namespace App\Controller;

use App\Entity\Estimation;
use App\Form\Estimation1Type;
use App\Repository\EstimationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/estimation")
 */
class EstimationController extends Controller
{
    /**
     * @Route("/", name="estimation_index", methods={"GET"})
     */
    public function index(EstimationRepository $estimationRepository): Response
    {
        return $this->render('estimation/index.html.twig', [
            'estimations' => $estimationRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="estimation_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $estimation = new Estimation();
        $form = $this->createForm(EstimationType::class, $estimation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($estimation);
            $entityManager->flush();

            return $this->redirectToRoute('estimation_index');
        }

        return $this->render('estimation/new.html.twig', [
            'estimation' => $estimation,
            'form' => $form->createView(),
            'type' => "Ajouter",
        ]);
    }

    /**
     * @Route("/{id}", name="estimation_show", methods={"GET"})
     */
    public function show(Estimation $estimation): Response
    {
        return $this->render('estimation/show.html.twig', [
            'estimation' => $estimation,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="estimation_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Estimation $estimation): Response
    {
        $estimation2 = $estimation;
        $form = $this->createForm(EstimationType::class, $estimation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if($estimation->getImage()==null)
            {
                $estimation->setImage($estimation2->getImage());
            }
            
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('estimation_index');
        }

        return $this->render('estimation/new.html.twig', [
            'estimation' => $estimation,
            'form' => $form->createView(),
            'type' => "Modifier",
        ]);
    }

    /**
     * @Route("/{id}", name="estimation_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Estimation $estimation): Response
    {
        if ($this->isCsrfTokenValid('delete'.$estimation->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($estimation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('estimation_index');
    }
}
