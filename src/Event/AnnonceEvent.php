<?php
/**
 * Created by PhpStorm.
 * User: europeonline
 * Date: 27/07/2019
 * Time: 12:45
 */

namespace App\Event;


use App\Entity\Affectation;
use App\Entity\AffectationConfirme;
use App\Entity\Annonce;
use App\Repository\AnnonceRepository;
use Doctrine\ORM\EntityManager;
use FOS\UserBundle\Event\FilterUserResponseEvent;
use Symfony\Component\HttpFoundation\Session\Session;

class AnnonceEvent
{
    private $session;
    private $em;
    private $mailer;


    public function __construct(Session $session, EntityManager $em, \Swift_Mailer $mailer)
    {
        $this->session = $session;
        $this->em = $em;
        $this->mailer = $mailer;
    }

    public function annonceOnConfirmed(FilterUserResponseEvent $event)
    {
        $id = $this->session->get("annonceId");
        if( !$id){
            $id = 0;
        }
        /**
         * @var Annonce $annonce
         */
        $annonce = $this->em->getRepository('App:Annonce')->find($id);
        if($annonce){
            $annonce->setClient($event->getUser());

            $affectation = new Affectation();
            $affectation->setAnnonce($annonce);

            $affectationconfirmer = new AffectationConfirme();
            $affectationconfirmer->setAnnonce($annonce);

            $this->em->persist($annonce);
            $this->em->persist($affectation);
            $this->em->persist($affectationconfirmer);

            $this->em->flush();

            $message = (new \Swift_Message('Nouvelle annonce'))
                ->setFrom('support@easylink.com')
                ->setTo($event->getUser()->getEmail())
                ->setBody('l annonce enregistrer besoin dun texte pour sa')
            ;

            $this->mailer->send($message);
            $session = new Session();
            $session->getFlashBag()->add('annonce',"Votre annonce a été enregistrée");
            $this->session->remove("annonceId");
        }

        $user = $event->getUser();
        $user->addRole("ROLE_CLIENT");
        $this->em->merge($user);
        $this->em->flush();



    }

}