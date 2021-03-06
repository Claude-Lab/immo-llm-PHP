<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository extends ServiceEntityRepository implements PasswordUpgraderInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(UserInterface $user, string $newHashedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
        }

        $user->setPassword($newHashedPassword);
        $this->_em->persist($user);
        $this->_em->flush();
    }

    /**
     * @return QueryBuilder
     */
    public function findByRole(string $role)
    {
        return $this->_em->createQueryBuilder()
            ->select('u')
            ->from($this->_entityName, 'u')
            ->where('u.roles LIKE :roles')
            ->setParameter('roles', '%"' . $role . '"%')
            ->orderBy('u.lastname', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * @return QueryBuilder
     */
    public function searchByTenant()
    {
        return $this->_em->createQueryBuilder()
            ->select('u')
            ->from($this->_entityName, 'u')
            ->where('u INSTANCE OF App\Entity\Tenant')
            ->orderBy('u.lastname', 'ASC');
    }

    /**
     * @return QueryBuilder
     */
    public function searchByOwner()
    {
        return $this->_em->createQueryBuilder()
            ->select('u')
            ->from($this->_entityName, 'u')
            ->where('u INSTANCE OF App\Entity\Owner')
            ->orderBy('u.lastname', 'ASC');
    }

    /**
     * 
     */
    public function searchByGuarantor()
    {

        return $this->_em->createQueryBuilder()
            ->select('u')
            ->from($this->_entityName, 'u')
            ->where('u INSTANCE OF App\Entity\Guarantor')
            ->orderBy('u.lastname', 'ASC');
    }
}
