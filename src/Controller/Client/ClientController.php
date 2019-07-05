<?php

namespace App\Controller\Client;

use App\Entity\Annonce;
use App\Entity\Specialite;
use App\Repository\AnnonceRepository;
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

    /**
     * @Route("/annonce", name="client_annonce")
     */
    public function annonce(AnnonceRepository $annonceRepository)
    {

        /**
         * @var Annonce[] $annonces
         */
        $annonces = $annonceRepository->findBy(["client" => $this->getUser()]);

        return $this->render('client/annonce/index.html.twig', ["annonces" => $annonces]);
    }

    /**
     * @Route("/annonce/add", name="client_annonce_add")
     */
    public function add_annonce(AnnonceRepository $annonceRepository)
    {

        /**
         * @var Annonce[] $annonces
         */
        $annonces = $annonceRepository->findBy(["client" => $this->getUser()]);

        return $this->render('client/annonce/addannonce.html.twig', ["annonces" => $annonces]);
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
}
