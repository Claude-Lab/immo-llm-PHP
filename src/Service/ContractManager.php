<?php


namespace App\Service;
use Doctrine\ORM\EntityManagerInterface;

class ContractManager {

    protected $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function setContractToTenantsFromFormAndReturn($contract, $contractForm) {

        // get the tenants from form
        $user = $contractForm->get('tenants')->getData();
        // add contract to tenants
        $user->setTenantsContract($contract);

        return $user;

    }

}