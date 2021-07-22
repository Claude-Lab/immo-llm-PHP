<?php

namespace App\Repository;

use App\Entity\Heat;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Heat|null find($id, $lockMode = null, $lockVersion = null)
 * @method Heat|null findOneBy(array $criteria, array $orderBy = null)
 * @method Heat[]    findAll()
 * @method Heat[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HeatRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Heat::class);
    }

    // /**
    //  * @return Heat[] Returns an array of Heat objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('h.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Heat
    {
        return $this->createQueryBuilder('h')
            ->andWhere('h.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
