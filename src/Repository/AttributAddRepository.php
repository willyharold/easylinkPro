<?php

namespace App\Repository;

use App\Entity\AttributAdd;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method AttributAdd|null find($id, $lockMode = null, $lockVersion = null)
 * @method AttributAdd|null findOneBy(array $criteria, array $orderBy = null)
 * @method AttributAdd[]    findAll()
 * @method AttributAdd[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AttributAddRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, AttributAdd::class);
    }

    // /**
    //  * @return AttributAdd[] Returns an array of AttributAdd objects
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
    public function findOneBySomeField($value): ?AttributAdd
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
