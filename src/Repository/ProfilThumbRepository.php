<?php

namespace App\Repository;

use App\Entity\ProfilThumb;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ProfilThumb|null find($id, $lockMode = null, $lockVersion = null)
 * @method ProfilThumb|null findOneBy(array $criteria, array $orderBy = null)
 * @method ProfilThumb[]    findAll()
 * @method ProfilThumb[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ProfilThumbRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ProfilThumb::class);
    }

    // /**
    //  * @return ProfilThumb[] Returns an array of ProfilThumb objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?ProfilThumb
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
