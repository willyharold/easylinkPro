<?php

namespace App\Controller\Artisan;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/artisan")
 */

class ArtisanController extends Controller
{
    /**
     * @Route("/", name="artisan")
     */
    public function index()
    {
        return $this->render('artisan/dashboard/index.html.twig', [
            'controller_name' => 'ArtisanController',
        ]);
    }

    /**
     * @Route("/artisan/register", name="artisan_register")
     */
    public function register(){
        return $this->render('artisan/register.html.twig', [
            'controller_name' => 'ArtisanController',
        ]);
    }

    /**
     * @Route("/artisan/login", name="artisan_login")
     */
    public function login(){
        return $this->render('artisan/register.html.twig');
    }

    /**
     * @Route("/artisan/dashbord", name="artisan_dashbord")
     */
    public function dashbord(){
        return $this->render('artisan/dashbord.html.twig', [
            'controller_name' => 'ArtisanController',
        ]);
    }

    /**
     * @Route("/artisan/menu/{id}", name="artisan_menu")
     */
    public function menu($id=0){
        return $this->render('artisan/menu.html.twig', [
            'controller_name' => 'ArtisanController',
            'id'=>$id
        ]);
    }

}
