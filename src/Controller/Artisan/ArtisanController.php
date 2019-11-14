<?php

namespace App\Controller\Artisan;

use App\Entity\Abonnement;
use App\Entity\Affectation;
use App\Entity\AffectationConfirme;
use App\Entity\Annonce;
use App\Entity\ArtisanEtat;
use App\Entity\Estimation;
use App\Entity\Pack;
use App\Entity\Transaction;
use App\Repository\AbonnementRepository;
use App\Repository\AffectationConfirmeRepository;
use App\Repository\AffectationRepository;
use App\Repository\AnnonceRepository;
use App\Repository\ArtisanEtatRepository;
use App\Repository\EstimationRepository;
use App\Repository\PackRepository;
use Beelab\PaypalBundle\Paypal\Exception;
use Beelab\PaypalBundle\Paypal\Service;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManager;
use Knp\Component\Pager\PaginatorInterface;
use phpDocumentor\Reflection\Types\Resource_;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Routing\Annotation\Route;
use Omnipay\Omnipay;

/**
 * @Route("/artisan")
 */

class ArtisanController extends Controller
{
    /**
     * @Route("", name="artisan")
     */
    public function index()
    {
        return $this->render('artisan/index.html.twig', [
            'controller_name' => 'ArtisanController',
        ]);
    }


    /**
     * @Route("/dashbord", name="artisan_dashbord")
     */
    public function dashbord(){
        return $this->render('artisan/dashboard/index.html.twig', []);
    }

    /**
     * @Route("/menu/{id}", name="artisan_menu")
     */
    public function menu($id=0){
        return $this->render('artisan/menu.html.twig', [
            'controller_name' => 'ArtisanController',
            'id'=>$id
        ]);
    }

    /**
     * @Route("/profile", name="artisan_profile")
     */
    public function profile(){
        return $this->render('artisan/profile/profile.html.twig', [
            'controller_name' => 'ArtisanController',
        ]);
    }

    /**
     * @Route("/annonces", name="artisan_annonces")
     */
    public function annonces(AnnonceRepository $annonceRepository, PaginatorInterface $paginator, Request $request, ArtisanEtatRepository $artisanEtatRepository){

        $queryBuilder = $annonceRepository->getWithSearchQueryBuilder1($this->getUser());
        $pagination = $paginator->paginate(
            $queryBuilder, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            7/*limit per page*/
        );

        /**
         * @var ArtisanEtat[] $tabArtisanEtat
         */
        $tabArtisanEtat = $artisanEtatRepository->findBy(["artisan"=>$this->getUser()]) ;

        return $this->render('artisan/annonces/annonces_list.html.twig', ['pagination' => $pagination,'tabartisan'=>$tabArtisanEtat]);
    }

    /**
     * @Route("/annoncesValider", name="artisan_annonce_valider")
     */
    public function annonceValider(AnnonceRepository $annonceRepository, PaginatorInterface $paginator, Request $request)
    {

        $queryBuilder = $annonceRepository->getWithSearchQueryBuilder2($this->getUser());
        $pagination = $paginator->paginate(
            $queryBuilder, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            7/*limit per page*/
        );

        return $this->render('artisan/annonces/annonces_list_valider.html.twig', ['pagination' => $pagination]);
    }

    /**
     * @Route("/annoncesValider/view/{id}", name="artisan_annonce_valider_view")
     */
    public function view_annonce($id, AnnonceRepository $annonceRepository, Request $request)
    {

        /**
         * @var Annonce $annonce
         */
        $annonce = $annonceRepository->findOneBy(["id"=>$id]);


        return $this->render('artisan/annonces/viewannoncevalider.html.twig', ["annonce" => $annonce]);
    }

    /**
     * @Route("/estimationValider/view/{id}", name="artisan_estimation_valider_view")
     */
    public function view_estimation_valider($id, EstimationRepository $estimationRepository, Request $request)
    {

        /**
         * @var Estimation $estimation
         */
        $estimation = $estimationRepository->findOneBy(["id"=>$id]);


        return $this->render('artisan/annonces/viewannoncevalider.html.twig', ["estimation" => $estimation]);
    }

    /**
     * @Route("/annonces/{id}", name="artisan_annonce_view")
     */
    public function annonce_view(Annonce $id, \Swift_Mailer $mailer, ArtisanEtatRepository $artisanEtatRepository ,AnnonceRepository $annonceRepository, Request $request, ObjectManager $objectManager, AffectationRepository $affectationRepository, AffectationConfirmeRepository $affectationConfirmeRepository){

        $form = $this->createForm(FormType::class,$id);
        $etat = $artisanEtatRepository->findOneBy(["artisan"=>$this->getUser(),"annonce"=>$id]);

        if($request->getMethod() == "POST"){
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {

                $affectation = $affectationRepository->findOneBy(["annonce"=>$id]);
                $affectationconfirmer = $affectationConfirmeRepository->findOneBy(["annonce"=>$id]);
                $affectationconfirmer->addArtisan($this->getUser());
                //$affectation->removeArtisan($this->getUser());
                $id->setEtat("Selectionner");

                $objectManager->persist($affectation);
                $objectManager->persist($affectationconfirmer);
                $etat->setEtat("Confirmer");
                $objectManager->merge($etat);
                $objectManager->merge($id);
                $objectManager->flush();

                $session = new Session();
                $session->getFlashBag()->add('annonce',"Le client a été contacté");

                $user = $this->getUser();

                $message = (new \Swift_Message("Information de l'annonce"))
                    ->setFrom('support@easylink.com')
                    ->setTo($id->getClient()->getEmail())
                    ->setBody("email pour informer le client qu'un artisan a postuler pour l'annonce")
                ;
                $mailer->send($message);

                return $this->redirectToRoute('artisan_annonces');

            }
        }
        return $this->render('artisan/annonces/annonce_view.html.twig', [
            'annonce' => $id,'form'=>$form->createView(),"etat"=>$etat
        ]);
    }

    /**
     * @Route("/estimations/{id}", name="artisan_estimation_view")
     */
    public function estimation_view(Estimation $id, \Swift_Mailer $mailer,ArtisanEtatRepository $artisanEtatRepository, EstimationRepository $estimationRepository, Request $request, ObjectManager $objectManager, AffectationRepository $affectationRepository, AffectationConfirmeRepository $affectationConfirmeRepository){

        $form = $this->createForm(FormType::class,$id);
        $etat = $artisanEtatRepository->findOneBy(["artisan"=>$this->getUser(),"estimation"=>$id]);

        if($request->getMethod() == "POST"){
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {

                $affectation = $affectationRepository->findOneBy(["estimation"=>$id]);
                $affectationconfirmer = $affectationConfirmeRepository->findOneBy(["estimation"=>$id]);
                $affectationconfirmer->addArtisan($this->getUser());
                //$affectation->removeArtisan($this->getUser());
                $objectManager->persist($affectation);
                $objectManager->persist($affectationconfirmer);

                $etat->setEtat("Confirmer");
                $id->setEtat("Selectionner");
                $objectManager->merge($id);
                $objectManager->merge($etat);
                $objectManager->flush();

                $session = new Session();
                $session->getFlashBag()->add('estimation',"Le client a été contacté");

                $user = $this->getUser();

                $message = (new \Swift_Message("Information de l'estimation"))
                    ->setFrom('support@easylink.com')
                    ->setTo($id->getClient()->getEmail())
                    ->setBody("email pour informer le client qu'un artisan a postuler pour l'estimation")
                ;
                $mailer->send($message);

                return $this->redirectToRoute('artisan_estimation');

            }
        }

        return $this->render('artisan/estimation/estimation_view.html.twig', [
            'estimation' => $id,'form'=>$form->createView(),'etat'=>$etat
        ]);
    }

    /**
     * @Route("/abonement", name="artisan_abonement")
     */
    public function abonement(PackRepository $packRepository, Request $request,AbonnementRepository $abonnementRepository){
        $pack = $packRepository->findAll();
        $abonnements = $abonnementRepository->finduserabo($this->getUser());
        return $this->render('artisan/abonement/abonement.html.twig', ['packs' => $pack,'abonnements'=>$abonnements]);
    }

    /**
     * @Route("/initier_paiement/{id}", name="initier_paiement")
     */
    public function initier_paiement(Pack $id,PackRepository $packRepository, Service $service, Request $request){
        $transaction = new Transaction($id->getPrix());
        $transaction->setPrix((float)$id->getPrix());
        $transaction->setNumero(11999944);
        $transaction->setDateEn(new \DateTime());
        $transaction->setPack($id);
        $transaction->setArtisan($this->getUser());
        
        try {
            $response = $service->setTransaction($transaction)->start();
            $this->getDoctrine()->getManager()->persist($transaction);
            $this->getDoctrine()->getManager()->flush();
            return $this->redirect($response->getRedirectUrl());
        } catch (Exception $e) {
            throw new HttpException(503, 'Payment error', $e);
        }
        
    }

    /**
     * @Route("/success_payment", name="success_payment")
     * @throws \Exception
     */
    public function success_payment(PackRepository $packRepository, Service $service, Request $request, AbonnementRepository $abonnementRepository,ObjectManager $em, \Swift_Mailer $mailer){
        $token = $request->query->get('token');
        /**
         * @var Transaction $transaction
         */
        /**
         * @var \DateTime $date
         */
        $transaction = $this->getDoctrine()->getRepository('App:Transaction')->findOneByToken($token);
        if (null === $transaction) {
            throw $this->createNotFoundException(sprintf('Transaction with token %s not found.', $token));
        }
        $service->setTransaction($transaction)->complete();
        $this->getDoctrine()->getManager()->flush();
        if (!$transaction->isOk()) {
            return []; // or a Response (in case of error)
        }
        // j'enregistre l'abonnement
        $abonnement = new Abonnement();
        $abonnement->setEtat(true);
        $abonnement->setTransaction($transaction);
        $date  = $abonnement->getDateExp();
        $interval = new \DateInterval('P'.$transaction->getPack()->getDuree().'M');
        $date->add($interval);
        $abonnement->setDateExp($date);
        $abonnement->setEtat(true);
        $em->persist($abonnement);
        $em->flush();

        $user = $this->getUser();
        $message = (new \Swift_Message("Information du paiement "))
            ->setFrom('support@easylink.com')
            ->setTo($user->getEmail())
            ->setBody("email pour informer le client que son abonnement a réussi")
        ;
        $mailer->send($message);



        $session = new Session();
        $session->getFlashBag()->add('paiementReussi',"Votre abonnement a été effectué avec success");

        return $this->redirectToRoute("artisan_abonement");
    }

    /**
     * @Route("/error_payment", name="error_payment")
     */
    public function error_payment(PackRepository $packRepository, Service $service, Request $request){
        $token = $request->query->get('token');
        $transaction = $this->getDoctrine()->getRepository('App:Transaction')->findOneByToken($token);
        if (null === $transaction) {
            throw $this->createNotFoundException(sprintf('Transaction with token %s not found.', $token));
        }
        $transaction->cancel(null);
        $this->getDoctrine()->getManager()->flush();
        $session = new Session();
        $session->getFlashBag()->add('paiementError',"Impossible de terminer votre abonnement");
        return $this->redirectToRoute("artisan_abonement");
    }

    /**
     * @Route("/estimations", name="artisan_estimation")
     */
    public function estimation(PaginatorInterface $paginator,EstimationRepository $estimationRepository, ArtisanEtatRepository $artisanEtatRepository, Request $request){

        $queryBuilder = $estimationRepository->getWithSearchQueryBuilder1($this->getUser());
        $pagination = $paginator->paginate(
            $queryBuilder, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            7/*limit per page*/
        );

        /**
         * @var ArtisanEtat[] $tabArtisanEtat
         */
        $tabArtisanEtat = $artisanEtatRepository->findBy(["artisan"=>$this->getUser()]) ;
        return $this->render('artisan/estimation/estimation.html.twig', ['pagination' => $pagination,'tabartisan'=>$tabArtisanEtat]);
    }

    /**
     * @Route("/estimationsValider", name="artisan_estimation_valider")
     */
    public function estimationValider(PaginatorInterface $paginator,EstimationRepository $estimationRepository, Request $request){

        $queryBuilder = $estimationRepository->getWithSearchQueryBuilder2($this->getUser());
        $pagination = $paginator->paginate(
            $queryBuilder, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            7/*limit per page*/
        );

        return $this->render('artisan/estimation/estimation_valider.html.twig', ['pagination' => $pagination]);
    }



    public function nbrAnnonce(Request $request, AnnonceRepository $annonceRepository){
        $annonces = $annonceRepository->getWithSearchQueryBuilder1result($this->getUser());
        return new Response(count($annonces));
    }

    public function nbrEstimation(Request $request, EstimationRepository $estimationRepository){
        $estimation = $estimationRepository->getWithSearchQueryBuilder1result($this->getUser());
        return new Response(count($estimation));
    }

}
