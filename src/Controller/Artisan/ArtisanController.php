<?php

namespace App\Controller\Artisan;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class ArtisanController extends Controller
{
    /**
     * @Route("/artisan", name="artisan")
     */
    public function index()
    {
        return $this->render('artisan/index.html.twig', [
            'controller_name' => 'ArtisanController',
        ]);
    }
}
