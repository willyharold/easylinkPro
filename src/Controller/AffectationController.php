<?php

namespace App\Controller;

use App\Entity\Affectation;
use App\Entity\ArtisanEtat;
use App\Form\AffectationType;
use App\Repository\AffectationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/affectation")
 */
class AffectationController extends Controller
{
    /**
     * @Route("/", name="affectation_index", methods={"GET"})
     */
    public function index(AffectationRepository $affectationRepository): Response
    {
        return $this->render('affectation/index.html.twig', [
            'affectations' => $affectationRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="affectation_new", methods={"GET","POST"})
     */
    public function new(Request $request, \Swift_Mailer $mailer): Response
    {
        $affectation = new Affectation();
        $form = $this->createForm(AffectationType::class, $affectation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($affectation);


            foreach($affectation->getArtisan() as $artisan){
                $message = (new \Swift_Message("Proposition de travail"))
                    ->setFrom('support@easylink.com')
                    ->setTo($artisan->getEmail())
                    ->setBody("Une annonce vous a été affectée. Veuillez vous connecter pour en savoir plus")
                ;
                $mailer->send($message);

                $artisanEtat = new ArtisanEtat();
                $artisanEtat->setEtat("En attente");
                $artisanEtat->setAnnonce($affectation->getAnnonce());
                $artisanEtat->setEstimation($affectation->getEstimation());
                $artisanEtat->setArtisan($artisan);
                $entityManager->persist($artisanEtat);
            }
            $entityManager->flush();


            return $this->redirectToRoute('affectation_index');
        }

        return $this->render('affectation/new.html.twig', [
            'affectation' => $affectation,
            'form' => $form->createView(),
            'type' => "Ajouter",
        ]);
    }

    /**
     * @Route("/{id}", name="affectation_show", methods={"GET"})
     */
    public function show(Affectation $affectation): Response
    {
        return $this->render('affectation/show.html.twig', [
            'affectation' => $affectation,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="affectation_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Affectation $affectation): Response
    {
        $form = $this->createForm(AffectationType::class, $affectation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('affectation_index');
        }

        return $this->render('affectation/new.html.twig', [
            'affectation' => $affectation,
            'form' => $form->createView(),
            'type' => "Modifier",
        ]);
    }

    /**
     * @Route("/{id}", name="affectation_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Affectation $affectation): Response
    {
        if ($this->isCsrfTokenValid('delete'.$affectation->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($affectation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('affectation_index');
    }
}
