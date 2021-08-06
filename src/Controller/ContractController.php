<?php

namespace App\Controller;

use App\Entity\Contract;
use App\Entity\User;
use App\Form\ContractType;
use App\Repository\ContractRepository;
use App\Repository\HousingRepository;
use App\Repository\UserRepository;
use App\Service\ContractManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Id;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContractController extends AbstractController
{

    protected $entityManager;
    protected $contractRepository;
    protected $housingRepository;
    protected $eventDispatcher;

    public function __construct(
        EntityManagerInterface $entityManager,
        ContractRepository $contractRepository,
        HousingRepository $housingRepository,
        EventDispatcherInterface $eventDispatcher
    ) {
        $this->entityManager    = $entityManager;
        $this->contractRepository   = $contractRepository;
        $this->housingRepository   = $housingRepository;
        $this->eventDispatcher = $eventDispatcher;
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

        if ($contractForm->isSubmitted() && $contractForm->isValid() && $contract->getStartDate()->is) {

            $contractManager = new ContractManager($this->entityManager, $this->housingRepository);
            $contract = $contractManager->checkHousingAviability($contract, $contractForm);
            $contract = $contractManager->setContractToTenantsFromFormAndReturn($contract, $contractForm);
            $this->entityManager->persist($contract);
            $this->entityManager->flush();


            $this->addFlash("Création", "Succès de la création du contrat'");

            return $this->redirectToRoute('contract_list');
        } else {

            return $this->render('contract/create.html.twig', [
                'contract' => $contract,
                'contractForm' => $contractForm->createView()
            ]);
        }
    }

    #[Route('/admin/contract/detail/{id}', name: 'contract_admin_detail')]
    public function detail(int $id): Response
    {
        $contract = $this->contractRepository->find($id);

        return $this->render('contract/detail.html.twig', [
            'contract' => $contract,
                
        ]);
        
    }
}
