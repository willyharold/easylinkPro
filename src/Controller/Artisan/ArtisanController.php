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
     * @Route("/login", name="artisan_login")
     */
    public function login(){
        return $this->render('artisan/register.html.twig');
    }

    /**
     * @Route("/dashbord", name="artisan_dashbord")
     */
    public function dashbord(){
        return $this->render('artisan/dashbord.html.twig', [
            'controller_name' => 'ArtisanController',
        ]);
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
    public function annonces(){
        return $this->render('artisan/annonces/annonces_list.html.twig', [
            'controller_name' => 'ArtisanController',
        ]);
    }

    /**
     * @Route("/annonces/{id}", name="artisan_annonce_view")
     */
    public function annonce_view(){
        return $this->render('artisan/annonces/annonce_view.html.twig', [
            'controller_name' => 'ArtisanController',
        ]);
    }


    /**
     * @Route("/abonement", name="artisan_abonement")
     */
    public function abonement(){
        return $this->render('artisan/abonement/abonement.html.twig', [
            'controller_name' => 'ArtisanController',
        ]);
    }

}
