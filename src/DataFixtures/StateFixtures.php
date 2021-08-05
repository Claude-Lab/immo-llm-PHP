<?php

namespace App\DataFixtures;

use App\Entity\State;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;

class StateFixtures extends Fixture
{
      protected EntityManagerInterface $entityManager;
      public const STATE_REFERENCE = 'state';


      public function __construct(EntityManagerInterface $entityManager)
      {
            $this->entityManager = $entityManager;
      }

      public function load(ObjectManager $manager)
      {

            $this->saveState();
      }

      public function saveState()
      {

            $state = new State();
            $state->setName('Neuf');
            $this->entityManager->persist($state);
            $this->addReference(self::STATE_REFERENCE . '_' . '1', $state);

            $state = new State();
            $state->setName('Très bon état');
            $this->entityManager->persist($state);
            $this->addReference(self::STATE_REFERENCE . '_' . '2', $state);

            $state = new State();
            $state->setName('Bon état');
            $this->entityManager->persist($state);
            $this->addReference(self::STATE_REFERENCE . '_' . '3', $state);

            $state = new State();
            $state->setName('Etat Moyen');
            $this->entityManager->persist($state);
            $this->addReference(self::STATE_REFERENCE . '_' . '4', $state);

            $state = new State();
            $state->setName('Mauvais état');
            $this->entityManager->persist($state);
            $this->addReference(self::STATE_REFERENCE . '_' . '5', $state);

            $state = new State();
            $state->setName('Très mauvais état');
            $this->entityManager->persist($state);
            $this->addReference(self::STATE_REFERENCE . '_' . '6', $state);

            $this->entityManager->flush();
      }

      public function getOrder()
      {
            return 3;
      }
}
