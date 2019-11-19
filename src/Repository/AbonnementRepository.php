<?php

namespace App\Repository;

use App\Entity\Abonnement;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @method Abonnement|null find($id, $lockMode = null, $lockVersion = null)
 * @method Abonnement|null findOneBy(array $criteria, array $orderBy = null)
 * @method Abonnement[]    findAll()
 * @method Abonnement[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AbonnementRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Abonnement::class);
    }

    // /**
    //  * @return Abonnement[] Returns an array of Abonnement objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('a.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Abonnement
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
     /**
     * @return Abonnement[] Returns an array of Abonnement objects
     */
    public function finduserabo($user)
    {
        return  $this->createQueryBuilder('a')
                     ->leftJoin('a.transaction','t')
                     ->leftJoin('t.artisan','u')
                     ->Where('u =:val')
                     ->andWhere('a.etat = true')
                     ->setParameter('val',$user)
                     ->orderBy('a.dateExp','DESC')
                     ->setMaxResults(1)
                    ->getQuery()
                    ->getResult()
            ;
    }
    
     /**
     * @return Artisan[] Returns an array of Abonnement objects
     */
    public function findArtisan()
    {
         
        $abs = $this->createQueryBuilder('a')
                     ->leftJoin('a.transaction','t')
                     ->Where('a.etat = true')
                     ->getQuery()
                     ->getResult()
            ;
        $tab = new ArrayCollection();
        foreach($abs as $ab){
            $tab->add($ab->getTransaction()->getArtisan());
            //array_push($tab, $ab->getTransaction()->getArtisan());
        }
        return $tab;
    }

}
