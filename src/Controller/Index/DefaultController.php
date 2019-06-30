<?php

namespace App\Controller\Index;

use App\Entity\Specialite;
use App\Repository\SpecialiteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

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
    public function annonce(SpecialiteRepository $sprepo,Request $request){
        /**
         * @var Specialite $specialite
         */
        $specialite = $sprepo->findAll();

        if($request->isMethod("POST")) {

        }
        return $this->render('client/annonce.html.twig', [
            'controller_name' => 'ClientController',
            'categories' => $specialite
        ]);
    }

}
