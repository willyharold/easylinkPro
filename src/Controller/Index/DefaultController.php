<?php

namespace App\Controller\Index;

use App\Entity\Affectation;
use App\Entity\AffectationConfirme;
use App\Entity\Annonce;
use App\Entity\Specialite;
use App\Form\Annonce2Type;
use App\Repository\SpecialiteRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class DefaultController extends Controller
{
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
     * @Route("/blog", name="blog")
     */
    public function blog()
    {
        return $this->render('default/blog.html.twig');
    }

    /**
     * @Route("/contact", name="contact")
     */
    public function contact()
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
