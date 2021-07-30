<?php

namespace App\EventListener;

use App\Entity\Contract;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Event\LifecycleEventArgs;

class ContractListener {

    protected $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function preUpdate(LifecycleEventArgs $arg): void
    {
        $entity = $arg->getEntity();

        if (true == property_exists($entity, property: 'startDate') && ($entity instanceof Contract)) {
            $entity->getStartDate();
            dd('preUpdate', $entity);
        }
    }

    public function postUpdate(LifecycleEventArgs $arg): void
    {
        $entity = $arg->getEntity();

        if (true == property_exists($entity, property: 'startDate') && ($entity instanceof Contract)) {
            $entity->getStartDate();
            dd('postUpdate', $entity);
        }
    }

}