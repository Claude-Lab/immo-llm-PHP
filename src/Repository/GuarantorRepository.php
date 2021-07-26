<?php

namespace App\Repository;

use App\Entity\Guarantor;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Guarantor|null find($id, $lockMode = null, $lockVersion = null)
 * @method Guarantor|null findOneBy(array $criteria, array $orderBy = null)
 * @method Guarantor[]    findAll()
 * @method Guarantor[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GuarantorRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Guaranty::class);
    }

    // /**
    //  * @return Guaranty[] Returns an array of Guaranty objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('g.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Guaranty
    {
        return $this->createQueryBuilder('g')
            ->andWhere('g.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
