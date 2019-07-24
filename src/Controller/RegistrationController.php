<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationController extends Controller
{
    /**
     * @Route("/artisan/register", name="fos_user_registration_artisan_register")
     */
    public function index(Request $request)
    {
        $usermanager = $this->get('fos_user.user_manager');

        $user =$usermanager->createUser();
        $form = $this->createForm(UserType::class, $user);
        if($request->getMethod()== 'POST'){
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $usermanager->updateUser($user);
                return $this->redirectToRoute('default');
            }
        }
        return $this->render('artisan/register.html.twig',["form"=>$form->createView()]);
    }
}
