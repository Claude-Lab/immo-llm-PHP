<?php

namespace App\Repository;

use App\Entity\PropertyLoad;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method PropertyLoad|null find($id, $lockMode = null, $lockVersion = null)
 * @method PropertyLoad|null findOneBy(array $criteria, array $orderBy = null)
 * @method PropertyLoad[]    findAll()
 * @method PropertyLoad[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PropertyLoadRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PropertyLoad::class);
    }
}
