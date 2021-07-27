<?php

namespace App\Repository;

use App\Entity\Owner;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
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

    protected $em;

    public function __construct(ManagerRegistry $registry, EntityManagerInterface $em)
    {
        parent::__construct($registry, Owner::class);
        $this->em = $em;
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

    public function findOwner()
    {

        return $this->createQueryBuilder('o')
            ->join('App\Entity\User', 'u')
            ->where('o.id = u.id')
            ->andWhere('App\Entity\Owner INSTANCE OF App\Entity\User')
            ->getQuery()
            ->getResult();
    }

    /**
     * @return Owner[] Returns an array of Owner objects
     */
    public function findByOwner()
    {
        $value = ["ROLE_OWNER"];

        return $this->createQueryBuilder('o')
            ->where('o.roles = :val')
            ->setParameter('val', $value);
        ;
    }

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
