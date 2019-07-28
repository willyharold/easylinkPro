<?php

namespace App\Controller\Client;

use App\Entity\Affectation;
use App\Entity\AffectationConfirme;
use App\Entity\Annonce;
use App\Entity\Avis;
use App\Entity\Specialite;
use App\Entity\User;
use App\Form\AnnonceType;
use App\Form\ClientInfoType;
use App\Repository\AnnonceRepository;
use App\Repository\AvisRepository;
use App\Repository\SpecialiteRepository;
use App\Repository\UserRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManager;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/client")
 */
class ClientController extends Controller
{
    /**
     * @Route("/", name="client")
     */
    public function index()
    {
        return $this->render('client/index.html.twig', [
            'controller_name' => 'ClientController',
        ]);
    }


    /**
     * @Route("/specialite/{id}", name="specialite")
     */
    public function specialite($id = 0){
        $em = $this->getDoctrine()->getManager();
        $specialite = $em->getRepository("App:Specialite")->findOneById($id);
        if($specialite){
            $sousspecialite = $em->getRepository("App:SousSpecialite")->findBySpecialite($specialite);

        }
        else{
            $sousspecialite = $em->getRepository("App:SousSpecialite")->findAll();

        }
        return $this->render('client/annonce-sousspecialite-js.html.twig',[
            'sousspecialites' => $sousspecialite
        ]);
    }


    /**
     * @Route("/annonce", name="client_annonce")
     */
    public function annonce(AnnonceRepository $annonceRepository, PaginatorInterface $paginator, Request $request)
    {

        $queryBuilder = $annonceRepository->getWithSearchQueryBuilder($this->getUser());
        $pagination = $paginator->paginate(
            $queryBuilder, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            7/*limit per page*/
        );

        return $this->render('client/annonce/index.html.twig', ['pagination' => $pagination]);
    }



    /**
     * @Route("/annonce/view/{id}", name="client_annonce_view")
     */
    public function view_annonce($id, \Swift_Mailer $mailer, AnnonceRepository $annonceRepository, Request $request, UserRepository $userRepository, ObjectManager $objectManager)
    {

        /**
         * @var Annonce $annonce
         */
        $annonce = $annonceRepository->findOneBy(["client" => $this->getUser(),"id"=>$id]);

        $form = $this->createForm(FormType::class,$annonce);
        if($request->getMethod() == "POST"){
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $artisan = $userRepository->findOneBy(["id"=>$request->request->get('form-artisan')]);
                $annonce->getAffectationConfirme()->setArtisanConfirme($artisan);
                $annonce->getAffectationConfirme()->setEtat(true);
                $objectManager->merge($annonce);
                $objectManager->flush();
                $session = new Session();
                $session->getFlashBag()->add('annonce',"L'artisan a été contacté");

                $user = $this->getUser();

                $message = (new \Swift_Message('Information du client'))
                    ->setFrom('support@easylink.com')
                    ->setTo($artisan->getEmail())
                    ->setBody('email pour donner les informations du client')
                ;
                $mailer->send($message);


                $message = (new \Swift_Message("Information de l'artisan"))
                    ->setFrom('support@easylink.com')
                    ->setTo($this->getUser()->getEmail())
                    ->setBody("email pour donner les informations de l'artisan")
                ;

                $mailer->send($message);
                return $this->redirectToRoute('client_annonce');
            }

        }
        return $this->render('client/annonce/viewannonce.html.twig', ["annonce" => $annonce,"form" => $form->createView()]);
    }

    /**
     * @Route("/information", name="client_information")
     */
    public function information(Request $request)
    {

        return $this->render('client/information/index.html.twig', ["user" => $this->getUser()]);
    }

    /**
     * @Route("/information/edit", name="client_information_edit")
     */
    public function edit_information(\Swift_Mailer $mailer,Request $request,ObjectManager $em)
    {

        $user = $this->getUser();
        $form = $this->createForm(ClientInfoType::class,$user);
        if($request->getMethod() == 'POST'){
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $em->persist($user);
                $em->flush();
                $session = new Session();
                $session->getFlashBag()->add('information',"Information modifiée");

                $user = $this->getUser();

                $message = (new \Swift_Message('Nouvelle annonce'))
                    ->setFrom('support@easylink.com')
                    ->setTo($user->getEmail())
                    ->setBody('email pour dire les informations ont été modifiées')
                ;

                $mailer->send($message);
                return $this->redirectToRoute('client_information');
            }

        }
        return $this->render('client/information/editinfo.html.twig', ["form" => $form->createView()]);
    }


    /**
     * @Route("/annonce/edit/{id}", name="client_annonce_edit")
     */
    public function edit_annonce(\Swift_Mailer $mailer, Annonce $id,AnnonceRepository $annonceRepository, Request $request, SpecialiteRepository $specialiteRepository, ObjectManager $em)
    {

        $form = $this->createForm(AnnonceType::class, $id);

        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {

                $id->setClient($this->getUser());
                $id->setEtat("En attente");
                $em->merge($id);
                $em->flush();

                $session = new Session();
                $session->getFlashBag()->add('annonce',"Votre annonce a été modifiée");

                return $this->redirectToRoute("client_annonce");
            }
        }

        /**
         * @var Specialite[] $specialites
         */

        $specialites = $specialiteRepository->findAll();
        return $this->render('client/annonce/addannonce.html.twig', ["form" => $form->createView(),"specialites"=>$specialites]);
    }

    /**
     * @Route("/annonce/add", name="client_annonce_add")
     */
    public function add_annonce(\Swift_Mailer $mailer, Request $request, AnnonceRepository $annonceRepository, ObjectManager $em, SpecialiteRepository $specialiteRepository)
    {

        /**
         * @var Annonce $annonce
         */
        $annonce = new Annonce();

        $form = $this->createForm(AnnonceType::class, $annonce);

        if ($request->getMethod() == 'POST') {
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {

                $annonce->setClient($this->getUser());
                $annonce->setEtat("En attente");
                $em->persist($annonce);

                $affectation = new Affectation();
                $affectation->setAnnonce($annonce);
                $affectationconfirmer = new AffectationConfirme();
                $affectationconfirmer->setAnnonce($annonce);

                $em->persist($affectation);
                $em->persist($affectationconfirmer);
                $em->flush();

                $user = $this->getUser();

                $message = (new \Swift_Message('Nouvelle annonce'))
                    ->setFrom('support@easylink.com')
                    ->setTo($user->getEmail())
                    ->setBody('l annonce enregistrer besoin dun texte pour sa')
                ;

                $mailer->send($message);
                $session = new Session();
                $session->getFlashBag()->add('annonce',"Votre annonce a été enregistré");

                return $this->redirectToRoute("client_annonce");
            }
        }

        /**
         * @var Specialite[] $specialites
         */

        $specialites = $specialiteRepository->findAll();
        return $this->render('client/annonce/addannonce.html.twig', ["form" => $form->createView(),"specialites"=>$specialites]);
    }



    /**
     * @Route("/estimation", name="client_estimation")
     */
    public function estimation(){
        return $this->render('client/estimation/index.html.twig');
    }

    /**
     * @Route("/avis", name="client_avis")
     */
    public function avis(PaginatorInterface $paginator, Request $request, AvisRepository $avisRepository){

        $queryBuilder = $avisRepository->getWithSearchQueryBuilder($this->getUser());
        $pagination = $paginator->paginate(
            $queryBuilder, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            7/*limit per page*/
        );
        return $this->render('client/avis/index.html.twig',["pagination"=>$pagination]);
    }

    /**
     * @Route("/avis/view/{id}", name="client_avis_view")
     */
    public function view_avis($id, Request $request, AvisRepository $avisRepository){


        /**
         * @var Avis $avis
         */
        $avis = $avisRepository->findOneBy(["client"=>$this->getUser(),"id"=>$id]);
        return $this->render('client/avis/viewavis.html.twig',["avis"=>$avis]);
    }


    public function menu($id=0){
        return $this->render('client/menu.html.twig', ['id'=>$id]);
    }

    public function nbrAnnonce(Request $request, AnnonceRepository $annonceRepository){
        $annonces = $annonceRepository->findByClient($this->getUser());
        return new Response(count($annonces));
    }

    public function nbrAvis(Request $request, AvisRepository $avisRepository){
        $avis  = $avisRepository->findBy(["client"=>$this->getUser()]);
        return new Response( count($avis));
    }
}
