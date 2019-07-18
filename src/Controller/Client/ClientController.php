<?php

namespace App\Controller\Client;

use App\Entity\Annonce;
use App\Entity\Specialite;
use App\Entity\User;
use App\Form\AnnonceType;
use App\Repository\AnnonceRepository;
use App\Repository\AvisRepository;
use App\Repository\SpecialiteRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManager;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
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
        $sousspecialite = $em->getRepository("App:SousSpecialite")->findBySpecialite($specialite);
        return $this->render('client/annonce-sousspecialite-js.html.twig',[
            'sousspecialites' => $sousspecialite
        ]);
    }

    /**
     * @Route("/register", name="client_register")
     */
    public function register(){
        return $this->render('client/register.html.twig');
    }

    /**
     * @Route("/annonce", name="client_annonce")
     */
    public function annonce(AnnonceRepository $annonceRepository, PaginatorInterface $paginator, Request $request)
    {

        /**
         * @var Annonce[] $annonces
         */
        $annonces = $annonceRepository->findBy(["client" => $this->getUser()],["dateEnreg"=>"DESC"]);

        $queryBuilder = $annonceRepository->getWithSearchQueryBuilder($this->getUser());
        $pagination = $paginator->paginate(
            $queryBuilder, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            7/*limit per page*/
        );

        return $this->render('client/annonce/index.html.twig', ["annonces" => $annonces,'pagination' => $pagination]);
    }

    /**
     * @Route("/annonce/view/{id}", name="client_annonce_view")
     */
    public function view_annonce($id, AnnonceRepository $annonceRepository, Request $request)
    {

        /**
         * @var Annonce $annonce
         */
        $annonce = $annonceRepository->findOneBy(["client" => $this->getUser(),"id"=>$id]);

        return $this->render('client/annonce/viewannonce.html.twig', ["annonce" => $annonce]);
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
                $session->getFlashBag()->add('annonce',"Votre annonce a été modifié");

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

                $em->flush();

                $user = $this->getUser();

                $message = (new \Swift_Message('Nouvelle annonce'))
                    ->setFrom('support@agrisoft.com')
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
    public function avis(){
        return $this->render('client/avis/index.html.twig');
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
