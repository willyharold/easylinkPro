<?php

namespace App\Controller\Artisan;

use App\Entity\Affectation;
use App\Entity\AffectationConfirme;
use App\Entity\Annonce;
use App\Repository\AffectationConfirmeRepository;
use App\Repository\AffectationRepository;
use App\Repository\AnnonceRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Knp\Component\Pager\PaginatorInterface;
use phpDocumentor\Reflection\Types\Resource_;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\HttpFoundation\Request;
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
    public function annonces(AnnonceRepository $annonceRepository, PaginatorInterface $paginator, Request $request){

        $queryBuilder = $annonceRepository->getWithSearchQueryBuilder1($this->getUser());
        $pagination = $paginator->paginate(
            $queryBuilder, /* query NOT result */
            $request->query->getInt('page', 1)/*page number*/,
            7/*limit per page*/
        );

        return $this->render('artisan/annonces/annonces_list.html.twig', ['pagination' => $pagination]);
    }

    /**
     * @Route("/annonces/{id}", name="artisan_annonce_view")
     */
    public function annonce_view(Annonce $id, AnnonceRepository $annonceRepository, Request $request, ObjectManager $objectManager, AffectationRepository $affectationRepository, AffectationConfirmeRepository $affectationConfirmeRepository){

        $form = $this->createForm(FormType::class,$id);

        if($request->getMethod() == "POST"){
            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {

                $affectation = $affectationRepository->findOneBy(["annonce"=>$id]);
                $affectationconfirmer = $affectationConfirmeRepository->findOneBy(["annonce"=>$id]);
                $affectationconfirmer->addArtisan($this->getUser());
                $affectation->removeArtisan($this->getUser());
                $objectManager->persist($affectation);
                $objectManager->persist($affectationconfirmer);
                $objectManager->flush();

                return $this->redirectToRoute('artisan_annonces');

            }
        }
        return $this->render('artisan/annonces/annonce_view.html.twig', [
            'annonce' => $id,'form'=>$form->createView()
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
