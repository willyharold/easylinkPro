<?php

namespace App\Repository;

use App\Entity\SousSpecialite;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method SousSpecialite|null find($id, $lockMode = null, $lockVersion = null)
 * @method SousSpecialite|null findOneBy(array $criteria, array $orderBy = null)
 * @method SousSpecialite[]    findAll()
 * @method SousSpecialite[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SousSpecialiteRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, SousSpecialite::class);
    }

    // /**
    //  * @return SousSpecialite[] Returns an array of SousSpecialite objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?SousSpecialite
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
