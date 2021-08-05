<?php

namespace App\DataFixtures;

use App\Entity\Tenant;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture implements DependentFixtureInterface
{

      protected EntityManagerInterface $entityManager;
      protected UserPasswordEncoderInterface $hash;

      public const USER_REFERENCE = 'user';

      public function __construct(UserPasswordEncoderInterface $hash, EntityManagerInterface $entityManager)
      {
            $this->hash = $hash;
            $this->entityManager = $entityManager;
      }

      public function load(ObjectManager $manager)
      {

            $this->saveUsers();
      }

      
      public function saveUsers()
      {


            for ($i = 0; $i <= 8; $i++) {

                  $faker = Factory::create('fr_FR');

                  $lastName = $faker->lastName;
                  $firstNane = $faker->firstName;

                  $user = new Tenant();
                  $user
                        ->setRoles(['ROLE_TENANT'])
                        ->setPassword($this->hash->encodePassword($user, 'aeaeae'))
                        ->setFirstname($firstNane)
                        ->setLastname($lastName)
                        ->setEmail(strtolower($firstNane . '.' . $lastName . $i . '@test.org'))
                        ->setMobile($faker->serviceNumber())
                        ->setPhone($faker->serviceNumber())
                        ->setAvatar('default.png')
                        ->setAddressBefore($this->getReference(AddressFixtures::ADDRESS_REFERENCE . '_' . $i));

                  $this->entityManager->persist($user);

                  $this->addReference(self::USER_REFERENCE . '_' . $i, $user);
            }

            $this->entityManager->flush();
      }

      public function getDependencies(): array
      {
            return [
                  AddressFixtures::class
            ];
      }

      public function getOrder()
      {
            return 2;
      }
}
