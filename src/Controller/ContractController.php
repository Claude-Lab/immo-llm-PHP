<?php

namespace App\Controller;

use App\Entity\Contract;
use App\Entity\Guarantor;
use App\Form\ContractType;
use App\Repository\ContractRepository;
use App\Repository\HousingRepository;
use App\Repository\UserRepository;
use App\Service\ContractManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContractController extends AbstractController
{

    protected $entityManager;
    protected $contractRepository;
    protected $housingRepository;
    protected $userRepository;

    public function __construct(
        EntityManagerInterface $entityManager,
        ContractRepository $contractRepository,
        HousingRepository $housingRepository,
        UserRepository $userRepository,
    ) {
        $this->entityManager        = $entityManager;
        $this->contractRepository   = $contractRepository;
        $this->housingRepository    = $housingRepository;
        $this->userRepository       = $userRepository;
    }


    #[Route('/manage/contracts', name: 'contract_list')]
    public function list(): Response
    {
        $contracts = $this->contractRepository->findAll();

        return $this->render('contract/list.html.twig', [
            'contracts' => $contracts,
        ]);
    }

    #[Route('/manage/contract/create', name: 'contract_create')]
    public function create(Request $request): Response
    {

        $contract = new Contract();
        $form = $this->createForm(ContractType::class, $contract);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
           
            $this->entityManager->persist($contract);
            $this->entityManager->flush();


            $this->addFlash("Création", "Succès de la création du contrat'");

            return $this->redirectToRoute('contract_list');
        } else {

            return $this->render('contract/create.html.twig', [
                'contract' => $contract,
                'form' => $form->createView()
            ]);
        }
    }

    #[Route('/manage/contract/detail/{id}', name: 'contract_detail')]
    public function detail(int $id): Response
    {
        $contract = $this->contractRepository->find($id);

        return $this->render('contract/detail.html.twig', [
            'contract'      => $contract,

        ]);
    }

    #[Route('/manage/contract/edit/{id}', name: 'contract_edit')]
    public function edit(Request $request, int $id): Response
    {
        $contract = $this->contractRepository->find($id);
        $form = $this->createForm(ContractType::class, $contract);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->entityManager->persist($contract);
            $this->entityManager->flush();


            $this->addFlash("Edit", "Succès de la modification du contrat'");

            return $this->redirectToRoute('contract_list');
        } else {

            return $this->render('contract/edit.html.twig', [
                'contract' => $contract,
                'form' => $form->createView()
            ]);
        }
    }

    #[Route('/manage/contract/delete/{id}', name: 'contract_delete')]
    public function delete(int $id): Response
    {
        $contract = $this->contractRepository->find($id);

        $this->entityManager->remove($contract);

        return $this->redirectToRoute('contract_list');
    }
}
