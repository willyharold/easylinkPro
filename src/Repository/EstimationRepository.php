<?php

namespace App\Repository;

use App\Entity\Estimation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Estimation|null find($id, $lockMode = null, $lockVersion = null)
 * @method Estimation|null findOneBy(array $criteria, array $orderBy = null)
 * @method Estimation[]    findAll()
 * @method Estimation[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EstimationRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Estimation::class);
    }

    // /**
    //  * @return Estimation[] Returns an array of Estimation objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Estimation
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function getWithSearchQueryBuilder($user)
    {
        return $this->createQueryBuilder('a')
            ->where('a.client =:val')
            ->setParameter('val', $user)
            ->orderBy('a.dateEn','DESC')
            ;
    }

    public function getWithSearchQueryBuilder1($user)
    {
        return $this->createQueryBuilder('a')
            ->leftJoin('a.affectation','affec')
            ->leftJoin('affec.artisan','art')
            ->where('art =:val')
            ->setParameter('val', $user)
            ->orderBy('a.dateEn','DESC')
            ;
    }

    public function getWithSearchQueryBuilder1result($user)
    {
        return $this->createQueryBuilder('a')
            ->leftJoin('a.affectation','affec')
            ->leftJoin('affec.artisan','art')
            ->where('art =:val')
            ->setParameter('val', $user)
            ->orderBy('a.dateEn','DESC')
            ->getQuery()
            ->getResult()
            ;
    }

    public function getWithSearchQueryBuilder2($user)
    {
        return $this->createQueryBuilder('a')
            ->leftJoin('a.affectationConfirme','affec')
            ->leftJoin('affec.artisanConfirme','art')
            ->where('art =:val')
            ->setParameter('val', $user)
            ->orderBy('a.dateEn','DESC')
            ;
    }
}
