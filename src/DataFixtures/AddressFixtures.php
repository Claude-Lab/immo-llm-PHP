<?php

namespace App\DataFixtures;

use App\Entity\Address;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AddressFixtures extends Fixture 
{
      protected EntityManagerInterface $entityManager;

      public const ADDRESS_REFERENCE = 'userAddress';

      public function __construct(EntityManagerInterface $entityManager)
      {
            $this->entityManager = $entityManager;
      }

      public function load(ObjectManager $manager)
      {

            $this->saveAddress();
      }

      public function saveAddress()
      {

            for ($i = 0; $i <= 10; $i++) {

                  $faker = Factory::create('fr_FR');

                  $userAddress = new Address();
                  $userAddress
                        ->setStreet($faker->streetAddress())
                        ->setCity($faker->city())
                        ->setPostCode($faker->postcode())
                        ->setCountry('France');

                  $this->entityManager->persist($userAddress);

                  $this->addReference(self::ADDRESS_REFERENCE . '_' . $i, $userAddress);
            }
            $this->entityManager->flush();
      }

      public function getOrder()
      {
            return 1;
      }
}
