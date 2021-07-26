<?php

namespace App\Repository;

use App\Entity\Owner;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @method Owner|null find($id, $lockMode = null, $lockVersion = null)
 * @method Owner|null findOneBy(array $criteria, array $orderBy = null)
 * @method Owner[]    findAll()
 * @method Owner[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OwnerRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Owner::class);
    }

    // public function getHousings(UserInterface $user)
    // {

    //     if (!$user instanceof Owner) {
    //         throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
    //     }

    //     $queryBuider = $this->createQueryBuilder('housing')
    //         ->select('owner')
    //         ->innerJoin('owner.id', 'user');
    // }

    public function getOwner()
    {
        /*
        * @var string
        */
        $owner = 'owner';

        return $this->createQueryBuilder('o')
            ->join('user', 'u')
            ->andWhere('u.type = :owner')
            ->setParameter('owner', $owner)
            ->orderBy('u.lastname', 'ASC')
            ->getQuery()
            ->getResult();
    }

    // /**
    //  * @return Owner[] Returns an array of Owner objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('o.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Owner
    {
        return $this->createQueryBuilder('o')
            ->andWhere('o.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
