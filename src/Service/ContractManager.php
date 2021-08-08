<?php


namespace App\Service;

use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;

class ContractManager
{

    protected $em;
    protected $repo;

    public function __construct(EntityManagerInterface $em, UserRepository $repo)
    {
        $this->em = $em;
        $this->repo = $repo;
    }

    public function setContractToGuarantorFromForm($contract, $form)
    {

        // get the guarantor from form
        $users = $form->get('guarantors')->getData();


        foreach ($users as $user) {
            // if ($user->getGuarantorContract() != null) {
            //   return 'fd';
            //}
            // add contract to guarantors
            $user->setGuarantorContract($contract);
            return $user;
        }
    }
}
