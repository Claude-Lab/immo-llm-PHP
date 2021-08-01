<?php

namespace App\DataFixtures;

use App\Entity\Heat;
use App\Entity\Sort;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;

class HeatFixtures extends Fixture
{
      protected EntityManagerInterface $entityManager;


      public function __construct(EntityManagerInterface $entityManager)
      {
            $this->entityManager = $entityManager;
      }

      public function load(ObjectManager $manager)
      {

            $this->saveHeat();
      }

      public function saveHeat()
      {

            $heat = new Heat();
            $heat->setName('Gaz de ville')
                  ->setFacilitie("Chaudière à condensation");
            $this->entityManager->persist($heat);

            $heat = new Heat();
            $heat->setName('Electrique')
                  ->setFacilitie("Radiateurs radiants");
            $this->entityManager->persist($heat);

            $heat = new Heat();
            $heat->setName('Gaz de ville')
                  ->setFacilitie("Chauffage central");
            $this->entityManager->persist($heat);

            $this->entityManager->flush();
      }

}
