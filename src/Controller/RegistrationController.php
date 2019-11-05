<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\SpecialiteRepository;
use App\Repository\UserRepository;
use Doctrine\Common\Persistence\ObjectManager;
use FOS\UserBundle\Event\FilterUserResponseEvent;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\FOSUserEvents;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;

class RegistrationController extends Controller
{
    /**
     * @Route("/artisan/register", name="fos_user_registration_artisan_register")
     */
    public function index(Request $request, TokenGeneratorInterface $tokenGenerator ,\Swift_Mailer $mailer,SpecialiteRepository $specialiteRepository)
    {
        $usermanager = $this->get('fos_user.user_manager');
        $eventDispatcher = $this->get('event_dispatcher');

        $user =$usermanager->createUser();
        $form = $this->createForm(UserType::class, $user);
        if($request->getMethod()== 'POST'){
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $event = new FormEvent($form, $request);
                $user->addRole("ROLE_ARTISAN");
                $user->setConfirmationToken($tokenGenerator->generateToken());

                $usermanager->updateUser($user);
                $url = $this->generateUrl('fos_user_registration_artisan_confirm', array('token' => $user->getConfirmationToken()), UrlGeneratorInterface::ABSOLUTE_URL);
                $message = (new \Swift_Message('Bienvenue '.$user->getUsername().' !'))
                    ->setFrom('support@easylink.com')
                    ->setTo($user->getEmail())
                    ->setBody("Bonjour ".$user->getUsername()." ! \nPour valider votre compte utilisateur, merci de vous rendre sur ".$url." \nCe lien ne peut être utilisé qu'une seule fois pour valider votre compte. \nCordialement, L'équipe Easylink");

                $mailer->send($message);

                return $this->render('artisan/check_email.html.twig',["user"=>$user]);
            }
        }
        $specialites = $specialiteRepository->findAll();
        return $this->render('artisan/register.html.twig',["form"=>$form->createView(),"specialittes"=>$specialites]);
    }

    /**
     * @Route("/artisan/register/confirm/{token}", name="fos_user_registration_artisan_confirm")
     */
    public function confirm($token, Request $request ,\Swift_Mailer $mailer, ObjectManager $objectManager, UserRepository $userRepository)
    {

        $user = $userRepository->findOneBy(["confirmationToken"=>$token]);
        if($user){
            $user->setEnabled(true);
            $objectManager->persist($user);
            $objectManager->flush();
            return $this->render('artisan/confirmed.html.twig');
        }
        else{
            return new Response("Utilisateur introuvable",500);
        }
    }
}
