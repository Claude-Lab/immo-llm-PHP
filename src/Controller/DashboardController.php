<?php

namespace App\Controller;

use App\Repository\ContractRepository;
use App\Repository\HousingRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractController
{
    protected $userRepo;
    protected $housingRepo;
    protected $contractRepo;

    public function __construct(UserRepository $userRepo, HousingRepository $housingRepo, ContractRepository $contractRepo)
    {
        $this->userRepo     = $userRepo;
        $this->housingRepo  = $housingRepo;
        $this->contractRepo = $contractRepo;
    }

    #[Route('/', name: 'dashboard')]
    public function dashboard(): Response
    {
        $contracts  = $this->contractRepo->findAll();
        $housings   = $this->housingRepo->findAll();

        return $this->render(
            'dashboard/dashboard.html.twig',
            [
                'contracts' => $contracts,
                'housings'  => $housings
            ]
        );
    }
}
