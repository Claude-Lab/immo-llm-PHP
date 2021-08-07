<?php

namespace App\Repository;

use App\Entity\Sort;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Sort|null find($id, $lockMode = null, $lockVersion = null)
 * @method Sort|null findOneBy(array $criteria, array $orderBy = null)
 * @method Sort[]    findAll()
 * @method Sort[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SortRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Sort::class);
    }
}
