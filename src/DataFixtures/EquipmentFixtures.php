<?php

namespace App\DataFixtures;

use App\Entity\Equipment;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class EquipmentFixtures extends Fixture implements DependentFixtureInterface
{
      protected EntityManagerInterface $entityManager;


      public function __construct(EntityManagerInterface $entityManager)
      {
            $this->entityManager = $entityManager;
      }

      public function load(ObjectManager $manager)
      {

            $this->saveEquipment();
      }

      public function saveEquipment()
      {
            for ($i = 0; $i <= 10; $i++) {
                $faker = Factory::create('fr_FR');

                $equipment = new Equipment();
                $equipment
                  ->setName('Equipement n°'.$i)
                  ->setBrandt($faker->company())
                  ->setSerialNumber($faker->regexify('[A-Z]{9}[0-4]{6}'))
                  ->setDescription($faker->sentence(5))
                  ->setState($this->getReference(StateFixtures::STATE_REFERENCE . '_' . mt_rand(1,6)));

                $this->entityManager->persist($equipment);
            }
            $this->entityManager->flush();
      }

      public function getDependencies(): array
      {
            return [
                  StateFixtures::class
            ];
      }

      public function getOrder()
      {
            return 4;
      }
}
