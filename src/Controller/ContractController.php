<?php

namespace App\Controller;

use App\Entity\Contract;
use App\Form\ContractType;
use App\Repository\ContractRepository;
use App\Repository\HousingRepository;
use App\Repository\UserRepository;
use App\Service\ContractManager;
use Doctrine\ORM\EntityManagerInterface;
use MercurySeries\FlashyBundle\FlashyNotifier;
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
    protected $contractManager;
    protected $flashy;

    public function __construct(
        EntityManagerInterface $entityManager,
        ContractRepository $contractRepository,
        HousingRepository $housingRepository,
        UserRepository $userRepository,
        ContractManager $contractManager,
        FlashyNotifier $flashy,
    ) {
        $this->entityManager        = $entityManager;
        $this->contractRepository   = $contractRepository;
        $this->housingRepository    = $housingRepository;
        $this->userRepository       = $userRepository;
        $this->contractManager      = $contractManager;
        $this->flashy               = $flashy;
    }


    #[Route('/manage/contracts', name: 'contract_list')]
    public function list(): Response
    {
        $contracts = $this->contractRepository->findAll();

        return $this->render('contract/list.html.twig', [
            'contracts' => $contracts,
        ]);
    }

    #[Route('/manage/contract/create/{id}', name: 'contract_create')]
    public function create(Request $request, int $id): Response
    {
        $housing = $this->housingRepository->find($id);
        $contract = new Contract();
        $form = $this->createForm(ContractType::class, $contract);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $contract->setHousing($housing);

            /**
             * @var bool $check
             */
            $check = $this->contractManager->checkContractDate($form, $housing, $id);

            if ($check == true) {
                $this->flashy->error('Impossible de créer le contrat : Vérifiez si le logement n\'a pas déjà un contrat en cours sur la période séléctionnée.');

                return $this->render('contract/create.html.twig', [
                    'contract' => $contract,
                    'housing'   => $housing,
                    'form' => $form->createView()
                ]);
            }

            $this->entityManager->persist($contract);
            $this->entityManager->flush();
            $this->flashy->success('Succès de la création du contrat');
            return $this->redirectToRoute('housing_list');
        } else {

            return $this->render('contract/create.html.twig', [
                'contract'  => $contract,
                'housing'   => $housing,
                'form'      => $form->createView()
            ]);
        }
    }

    #[Route('/manage/contract/detail/{id}', name: 'contract_detail')]
    public function detail(int $id): Response
    {
        $contract = $this->contractRepository->find($id);
        $housing = $contract->getHousing();

        return $this->render('contract/detail.html.twig', [
            'contract'      => $contract,
            'housing'       => $housing
        ]);
    }

    #[Route('/manage/contract/edit/{id}', name: 'contract_edit')]
    public function edit(Request $request, int $id): Response
    {
        $contract = $this->contractRepository->find($id);
        $housing = $contract->getHousing();
        $form = $this->createForm(ContractType::class, $contract);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $check = $this->contractManager->checkContractDate($form, $housing, $id);

            if ($check == true) {
                $this->flashy->error('Impossible de modifier le contrat : Vérifiez si le logement n\'a pas déjà un contrat en cours sur la période séléctionnée.');

                return $this->render('contract/create.html.twig', [
                    'contract' => $contract,
                    'housing'       => $housing,
                    'form' => $form->createView()
                ]);
            }
            $this->entityManager->persist($contract);
            $this->entityManager->flush();
            $this->flashy->success('Succès de la modification du contrat');
            return $this->redirectToRoute(
                'housing_detail',
                ['id' => $housing->getId()]
            );
        } else {

            return $this->render('contract/edit.html.twig', [
                'contract'  => $contract,
                'housing'   => $housing,
                'form'      => $form->createView()
            ]);
        }
    }

    #[Route('/manage/contract/delete/{id}', name: 'contract_delete')]
    public function delete($id): Response
    {

        $contract = $this->contractRepository->find($id);
        $housing = $contract->getHousing();
        $HousingId = $housing->getId();

        $this->entityManager->remove($contract);
        $this->entityManager->flush();
        $this->flashy->success('Succès de la suppreion du contrat');
        return $this->redirectToRoute(
            'housing_detail',
            ['id' => $HousingId]
        );
    }
}
