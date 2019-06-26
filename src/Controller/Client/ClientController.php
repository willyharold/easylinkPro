<?php

namespace App\Controller\Client;

use App\Entity\Specialite;
use App\Repository\SpecialiteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
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
}
