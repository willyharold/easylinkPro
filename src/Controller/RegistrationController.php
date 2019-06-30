<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class RegistrationController extends Controller
{
    /**
     * @Route("/artisan/register", name="fos_user_registration_artisan_register")
     */
    public function index()
    {
        return $this->render('artisan/register.html.twig');
    }
}
