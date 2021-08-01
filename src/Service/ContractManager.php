<?php


namespace App\Service;

use App\Repository\HousingRepository;
use Doctrine\ORM\EntityManagerInterface;

class ContractManager {

    protected $em;
    protected $housingRepository;

    public function __construct(EntityManagerInterface $em, HousingRepository $housingRepository)
    {
        $this->em = $em;
        $this->housingRepository = $housingRepository;
    }

    public function setContractToTenantsFromFormAndReturn($contract, $contractForm) {

        // get the tenants from form
        $user = $contractForm->get('tenants')->getData();
        
        // add contract to tenants
        $user->setTenantsContract($contract);

        return $user;
    }

    public function checkHousingAviability($contract, $contractForm) {

        
        $startDate = $contractForm->get('startDate')->getData();
        $endDate = $contractForm->get('endDate')->getData();

        /**
         * @var Housing $data
         */
        $data = $contractForm->get('housing')->getData();

        $housing = $this->housingRepository->find($data);

        if ((($housing->getContract()->getStartDate() < $startDate) && ($housing->getContract()->getEndDate() < $endDate))
            || (($housing->getContract()->getStartDate() < $startDate) && ($housing->getContract()->getEndDate() == null)))
        {
            return $data;
        } else {
            return $message = 'Un contrat concernant ce logement est déjà en cours sur les dates indiquées';
        }
    }

}