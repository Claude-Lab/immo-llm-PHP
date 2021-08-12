<?php


namespace App\Service;

use App\Repository\HousingRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ContractManager
{

    protected $em;
    protected $contractRepo;
    protected $housingRepository;

    public function __construct(
        EntityManagerInterface $em,
        UserRepository $contractRepo,
        HousingRepository $housingRepository
    ) {
        $this->em                   = $em;
        $this->contractRepo         = $contractRepo;
        $this->housingRepository    = $housingRepository;
    }


    public function checkContractDate($form, $housing, $id)
    {
        $formStartDate = $form->get('startDate')->getData();
        $formEndDate = $form->get('endDate')->getData();
        $contractEdit = $this->contractRepo->find($id);

        $housingCheck = $this->housingRepository->find($housing);

        if ($housingCheck == null) {
            return new NotFoundHttpException('Aucun logement trouvé');
        } else {
            $contracts = $housingCheck->getContracts();


            foreach ($contracts as $contract) {
                $housingStart   = $contract->getStartDate();
                $housingEnd     = $contract->getEndDate();

                if ($contract == $contractEdit)continue;

                if (($housingStart > $formStartDate) && ($housingStart < $formEndDate)) {
                    return true;
                } elseif (($housingStart < $formStartDate) && ($housingEnd > $formEndDate)) {
                    return true;
                } elseif (($housingEnd < $formStartDate) && ($housingEnd > $formEndDate)) {
                    return true;
                } elseif (($housingStart > $formStartDate) && ($housingEnd < $formEndDate)) {
                    return true;
                } else {
                    return false;
                }
            }
        }
    }
}
