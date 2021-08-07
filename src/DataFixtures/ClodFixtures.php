<?php

namespace App\DataFixtures;

use App\Entity\Address;
use App\Entity\Admin;
use App\Entity\Guarantor;
use App\Entity\Owner;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class ClodFixtures extends Fixture
{

      protected $entityManager;
      protected $hash;
      public const CLOD_REFERENCE = 'clodAddress';
      public const FABI_REFERENCE = 'fabiAddress';
      public const NONO_REFERENCE = 'nonoAddress';

      public function __construct(EntityManagerInterface $entityManager, UserPasswordEncoderInterface $hash)
      {
            $this->entityManager    = $entityManager;
            $this->hash             = $hash;
      }

      public function load(ObjectManager $manager)
      {
            $this->saveAddress();
            $this->saveClod();
      }

      public function saveAddress()
      {
            $userAddress = new Address();
            $userAddress
                  ->setStreet('1 rue Jeanne Malivel')
                  ->setCity('Rennes')
                  ->setPostCode('35000')
                  ->setCountry('France');

            $this->entityManager->persist($userAddress);
            $this->addReference(self::CLOD_REFERENCE, $userAddress);

            $this->entityManager->flush();

            $userAddress = new Address();
            $userAddress
                  ->setStreet('1 rue Jeanne Malivel')
                  ->setCity('Rennes')
                  ->setPostCode('35000')
                  ->setCountry('France');

            $this->entityManager->persist($userAddress);
            $this->addReference(self::FABI_REFERENCE, $userAddress);

            $this->entityManager->flush();

            $userAddress = new Address();
            $userAddress
                  ->setStreet('1 rue Jeanne Malivel')
                  ->setCity('Rennes')
                  ->setPostCode('35000')
                  ->setCountry('France');

            $this->entityManager->persist($userAddress);
            $this->addReference(self::NONO_REFERENCE, $userAddress);

            $this->entityManager->flush();
      }

      public function saveClod()
      {
            $user = new Admin();
                $user
                        ->setFirstname('Claude')
                        ->setLastname('Lusseau')
                        ->setEmail('claude.lusseau@yahoo.fr')
                        ->setPassword($this->hash->encodePassword($user, 'aeaeae'))
                        ->setRoles(['ROLE_ADMIN'])
                        ->setMobile('0605040609')
                        ->setPhone('0203336456')
                        ->setAvatar('ClaudeLusseau1-610e93caa4573.jpg');

                $this->entityManager->persist($user);
                $this->entityManager->flush();

            $user = new Owner();
                  $user
                        ->setFirstname('Fabienne')
                        ->setLastname('Le Marchand')
                        ->setEmail('f.le-marchand@laposte.net')
                        ->setPassword($this->hash->encodePassword($user, 'aeaeae'))
                        ->setRoles(['ROLE_OWNER'])
                        ->setMobile('0605040609')
                        ->setPhone('0203336456')
                        ->setAvatar('default.png')
                        ->setAddress($this->getReference(self::FABI_REFERENCE));

                  $this->entityManager->persist($user);
                  $this->entityManager->flush();
            
            $user = new Guarantor();
                  $user
                        ->setFirstname('Noela')
                        ->setLastname('Lusseau Le Marchand')
                        ->setEmail('n.le-marchand@laposte.net')
                        ->setPassword($this->hash->encodePassword($user, 'aeaeae'))
                        ->setRoles(['ROLE_GUARANTOR'])
                        ->setMobile('0605040609')
                        ->setPhone('0203336456')
                        ->setAvatar('default.png')
                        ->setAddress($this->getReference(self::NONO_REFERENCE));

                  $this->entityManager->persist($user);

                  $this->entityManager->flush();
      }
}
