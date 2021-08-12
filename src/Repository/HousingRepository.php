<?php

namespace App\Repository;

use App\Entity\Housing;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Housing|null find($id, $lockMode = null, $lockVersion = null)
 * @method Housing|null findOneBy(array $criteria, array $orderBy = null)
 * @method Housing[]    findAll()
 * @method Housing[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class HousingRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Housing::class);
    }

    public function findByName($name) {

        return $this->_em->createQueryBuilder()
            ->select('h')
            ->from($this->_entityName, 'h')
            ->where('h.name = :name')
            ->setParameter('name', '%"' . $name . '"%')
            ->getQuery()
            ->getResult();
    }


    public function checkDate($id, $dateStart, $dateEnd)
    {

        return $this->_em->createQueryBuilder()
            ->select('count(h)')
            ->from($this->_entityName, 'h')
            ->leftJoin('h.contracts', 'c')
            ->where('h.id = :id')
            ->andWhere(':dateStart NOT BETWEEN c.startDate AND c.endDate')
            ->andWhere(':dateEnd NOT BETWEEN c.startDate AND c.endDate')
            ->setParameter('id', $id)
            ->setParameter('dateStart', $dateStart)
            ->setParameter('dateEnd', $dateEnd)
            ->getQuery()
            ->getResult();
    }


}
