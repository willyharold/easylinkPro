<?php

namespace App\Controller\Index;

use App\Entity\Affectation;
use App\Entity\AffectationConfirme;
use App\Entity\Annonce;
use App\Entity\Specialite;
use App\Entity\Abonnement;
use App\Entity\ArticleBlog;
use App\Entity\Artisan;
use App\Entity\AttributAdd;
use App\Entity\AttributAddRep;
use App\Entity\Avis;
use App\Entity\CategorieBlog;
use App\Entity\Client;
use App\Entity\Coupon;
use App\Entity\Estimation;
use App\Entity\Newsletter;
use App\Entity\Pack;
use App\Entity\SousSpecialite;
use App\Entity\Transaction;
use App\Entity\User;
use App\Form\Annonce2Type;
use App\Repository\ArticleBlogRepository;
use App\Repository\CategorieBlogRepository;
use App\Repository\SpecialiteRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class DefaultController extends Controller
{
    /**
     * @Route("/admin/dashboard", name="dashboard")
     */
    public function dashboard()
    {
        return $this->render('accueil.html.twig',[
            'ab' => count($this->getDoctrine()->getRepository(Abonnement::class)->findAll()),
            'ac' => count($this->getDoctrine()->getRepository(AffectationConfirme::class)->findAll()),
            'af' => count($this->getDoctrine()->getRepository(Affectation::class)->findAll()),
            'an' => count($this->getDoctrine()->getRepository(Annonce::class)->findAll()),
            'art' => count($this->getDoctrine()->getRepository(ArticleBlog::class)->findAll()),
            'ar' => count($this->getDoctrine()->getRepository(Artisan::class)->findAll()),
            'aa' => count($this->getDoctrine()->getRepository(AttributAdd::class)->findAll()),
            'aar' => count($this->getDoctrine()->getRepository(AttributAddRep::class)->findAll()),
            'av' => count($this->getDoctrine()->getRepository(Avis::class)->findAll()),
            'ca' => count($this->getDoctrine()->getRepository(CategorieBlog::class)->findAll()),
            'cl' => count($this->getDoctrine()->getRepository(Client::class)->findAll()),
            'co' => count($this->getDoctrine()->getRepository(Coupon::class)->findAll()),
            'es' => count($this->getDoctrine()->getRepository(Estimation::class)->findAll()),
            'ne' => count($this->getDoctrine()->getRepository(Newsletter::class)->findAll()),
            'pa' => count($this->getDoctrine()->getRepository(Pack::class)->findAll()),
            'ss' => count($this->getDoctrine()->getRepository(SousSpecialite::class)->findAll()),
            'sp' => count($this->getDoctrine()->getRepository(Specialite::class)->findAll()),
            'tr' => count($this->getDoctrine()->getRepository(Transaction::class)->findAll()),
            'us' => count($this->getDoctrine()->getRepository(User::class)->findAll()),
        ]);
    }
    /**
     * @Route("/homepage", name="homepage")
     */
    public function homepage()
    {
        return $this->render('default/index.html.twig');
    }
    /**
     * @Route("/admin", name="admin")
     */
    public function admin()
    {
        return $this->redirectToRoute("dashboard");
    }

    /**
     * @Route("/", name="default")
     */
    public function index()
    {
        return $this->render('default/index.html.twig');
    }

    public function menu()
    {
        return $this->render('default/menu.html.twig');
    }

    public function menuArtisan()
    {
        return $this->render('default/menuArtisan.html.twig');
    }

    public function footer()
    {
        return $this->render('default/footer.html.twig');
    }

    /**
     * @Route("/trouverUnPro", name="trouverUnPro")
     */
    public function trouverUnPro(ArticleBlogRepository $articleBlogRepository)
    {
        $art = $articleBlogRepository->lastArticle();
        return $this->render('default/trouverunpro.html.twig', ["articles"=>$art]);
    }

    /**
     * @Route("/attribuEstimation/{id}", name="attribuEstimation")
     */
    public function attribuEstimation($id=0,Request $request, SpecialiteRepository $specialiteRepository)
    {

        $specialite = $specialiteRepository->find($id);
        return $this->render('client/estimation/attribut-estimation-js.html.twig', ["specialite"=>$specialite]);
    }

    /**
     * @Route("/sousspecialite/{id}", name="sousSpecilaitejs")
     */
    public function sousSpecilaitejs($id=0,Request $request, SpecialiteRepository $specialiteRepository)
    {

        $specialite = $specialiteRepository->find($id);
        return $this->render('client/sousSpecialite-js.html.twig', ["specialite"=>$specialite]);
    }

    /**
     * @Route("/blog", name="blog")
     */
    public function blog( PaginatorInterface $paginator, Request $request,ArticleBlogRepository $articleBlogRepository)
    {
        $queryBuilder = $articleBlogRepository->getWithSearchQueryBuilder();
        $pagination = $paginator->paginate(
            $queryBuilder, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            3/*limit per page*/
        );
        return $this->render('default/blog.html.twig', ['pagination' => $pagination]);
    }

    /**
     * @Route("/contact", name="contact")
     */
    public function contact()
    {
        return $this->render('default/contact.html.twig');
    }

    public function rightblog(CategorieBlogRepository $categorieBlogRepository, ArticleBlogRepository $articleBlogRepository)
    {
        $categories = $categorieBlogRepository->findcat();

        $articles = $articleBlogRepository->lastArticle();

        return $this->render('default/recentNews.html.twig',['articles'=>$articles,'categories'=>$categories]);
    }

    /**
     * @Route("/annuaire", name="annuaire")
     */
    public function annuaire()
    {
        return $this->render('default/contact.html.twig');
    }


    /**
     * @Route("/about", name="about")
     */
    public function about()
    {
        return $this->render('default/about.html.twig');
    }

    /**
     * @Route("/annonce", name="annonce")
     */
    public function annonce(\Swift_Mailer $mailer, ObjectManager $em,SpecialiteRepository $sprepo,Request $request,  AuthorizationCheckerInterface $authChecker){
        /**
         * @var Specialite $specialite
         */
        $specialite = $sprepo->findAll();

        $annonce = new Annonce();
        $form = $this->createForm(Annonce2Type::class,$annonce);

        if($request->isMethod("POST")) {
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                if($authChecker->isGranted('ROLE_USER')){
                    $annonce->setEtat("En attente");
                    $annonce->setClient($this->getUser());
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
                else{
                    $annonce->setEtat("En attente");
                    $em->persist($annonce);
                    $em->flush();
                    $session = new Session();
                    $session->set('annonceId',$annonce->getId());
                    return $this->redirectToRoute("fos_user_registration_register");

                }
            }

        }
        return $this->render('client/annonce.html.twig', [
            'form' => $form->createView(),
            'categories' => $specialite
        ]);
    }

}
