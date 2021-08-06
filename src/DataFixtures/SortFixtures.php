<?php

namespace App\DataFixtures;

use App\Entity\Sort;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;

class SortFixtures extends Fixture
{
      protected EntityManagerInterface $entityManager;


      public function __construct(EntityManagerInterface $entityManager)
      {
            $this->entityManager = $entityManager;
      }

      public function load(ObjectManager $manager)
      {

            $this->saveSort();
      }

      public function saveSort()
      {

            $sort = new Sort();
            $sort->setName('Maison');
            $this->entityManager->persist($sort);

            $sort = new Sort();
            $sort->setName('Appartement');
            $this->entityManager->persist($sort);

            $sort = new Sort();
            $sort->setName('Garage');
            $this->entityManager->persist($sort);

            $this->entityManager->flush();
      }
}
