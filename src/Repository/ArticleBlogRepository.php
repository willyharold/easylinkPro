<?php

namespace App\Repository;

use App\Entity\ArticleBlog;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method ArticleBlog|null find($id, $lockMode = null, $lockVersion = null)
 * @method ArticleBlog|null findOneBy(array $criteria, array $orderBy = null)
 * @method ArticleBlog[]    findAll()
 * @method ArticleBlog[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleBlogRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, ArticleBlog::class);
    }

    // /**
    //  * @return ArticleBlog[] Returns an array of ArticleBlog objects
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
    public function findOneBySomeField($value): ?ArticleBlog
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function getWithSearchQueryBuilder()
    {
        return $this->createQueryBuilder('a')
            ->where('a.etat = 1')
            ->orderBy('a.datePub','DESC')
            ;
    }
    public function lastArticle(){
        return $this->createQueryBuilder('a')
            ->setMaxResults(3)
            ->orderBy('a.datePub','DESC')
            ->getQuery()
            ->getResult();
    }
}
