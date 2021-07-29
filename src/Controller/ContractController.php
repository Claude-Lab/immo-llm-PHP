<?php

namespace App\Controller;

use App\Entity\Contract;
use App\Form\ContractType;
use App\Repository\ContractRepository;
use App\Repository\HousingRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContractController extends AbstractController
{

    protected $entityManager;
    protected $contractRepository;

    public function __construct(
        EntityManagerInterface $entityManager,
        ContractRepository $contractRepository,
    ) {
        $this->entityManager    = $entityManager;
        $this->contractRepository   = $contractRepository;
    }


    #[Route('/admin/contract/list', name: 'contract_list')]
    public function list(): Response
    {
        $contracts = $this->contractRepository->findAll();

        return $this->render('contract/list.html.twig', [
            'contracts' => $contracts,
        ]);
    }

    #[Route('/admin/contract/create', name: 'contract_create')]
    public function create(Request $request): Response
    {
        $contract = new Contract();
        $contractForm = $this->createForm(ContractType::class, $contract);
        $contractForm->handleRequest($request);

        if ($contractForm->isSubmitted() && $contractForm->isValid()) {

            $this->entityManager->persist($contract);
            $this->entityManager->flush();
            $this->addFlash("Création", "Succès de la création d'un équipement'");

            return $this->redirectToRoute('contract_list');
        } else {

            return $this->render('contract/create.html.twig', [
                'contract' => $contract,
                'contractForm' => $contractForm->createView()
            ]);
        }
    }
}
