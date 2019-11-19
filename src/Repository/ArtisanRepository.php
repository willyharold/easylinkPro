<?php

namespace App\Repository;

use App\Entity\Artisan;
use App\Entity\Specialite;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Artisan|null find($id, $lockMode = null, $lockVersion = null)
 * @method Artisan|null findOneBy(array $criteria, array $orderBy = null)
 * @method Artisan[]    findAll()
 * @method Artisan[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArtisanRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Artisan::class);
    }

    // /**
    //  * @return Artisan[] Returns an array of Artisan objects
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
    public function findOneBySomeField($value): ?Artisan
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */

    public function getWithSearchQueryBuilder1()
    {
        return $this->createQueryBuilder('a')
            ->orderBy('a.dateCreateAt','DESC')
            ;
    }

    public function getWithSearchQueryBuilder2(Specialite $specialite, $codepostal)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.codePostal = :val1')
            ->setParameter('val1',$codepostal)
            ->leftJoin('a.sousSpecialite','ss')
            ->leftJoin('ss.specialite','s')
            ->andWhere('s.id = :val2')
            ->setParameter('val2',$specialite->getId())
            ->orderBy('a.dateCreateAt','DESC')
            ;
    }
    public function getWithSearchQueryBuilder3(Specialite $specialite)
    {
        return $this->createQueryBuilder('a')
            ->leftJoin('a.sousSpecialite','ss')
            ->leftJoin('ss.specialite','s')
            ->andWhere('s.id = :val2')
            ->setParameter('val2',$specialite->getId())
            ->orderBy('a.dateCreateAt','DESC')
            ;
    }

    public function getWithSearchQueryBuilder4($codepostal)
    {
        return $this->createQueryBuilder('a')
            ->andWhere('a.codePostal = :val1')
            ->setParameter('val1',$codepostal)
            ->orderBy('a.dateCreateAt','DESC')
            ;
    }
}
