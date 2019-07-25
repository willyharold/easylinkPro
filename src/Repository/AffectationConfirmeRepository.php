<?php

namespace App\Repository;

use App\Entity\AffectationConfirme;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method AffectationConfirme|null find($id, $lockMode = null, $lockVersion = null)
 * @method AffectationConfirme|null findOneBy(array $criteria, array $orderBy = null)
 * @method AffectationConfirme[]    findAll()
 * @method AffectationConfirme[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AffectationConfirmeRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, AffectationConfirme::class);
    }

    // /**
    //  * @return AffectationConfirme[] Returns an array of AffectationConfirme objects
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
    public function findOneBySomeField($value): ?AffectationConfirme
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
