<?php

namespace App\Controller;

use App\Entity\Equipment;
use App\Form\EquipmentType;
use App\Form\EquipmentUpdateType;
use App\Repository\EquipmentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EquipmentController extends AbstractController
{

    protected $entityManager;
    protected $equipmentRepository;

    public function __construct(
        EntityManagerInterface $entityManager,
        EquipmentRepository $equipmentRepository,
    ) {
        $this->entityManager    = $entityManager;
        $this->equipmentRepository   = $equipmentRepository;
    }


    #[Route('/equipment/create', name: 'equipment_create')]
    public function create(Request $request): Response
    {
        $equipment = new Equipment();
        $equipmentForm = $this->createForm(EquipmentType::class, $equipment);
        $equipmentForm->handleRequest($request);

        if ($equipmentForm->isSubmitted() && $equipmentForm->isValid()) {

            $equipment->setInUse(false);

            $this->entityManager->persist($equipment);
            $this->entityManager->flush();
            $this->addFlash("Création", "Succès de la création d'un équipement'");

            return $this->redirectToRoute('equipment_list');
        } else {

            return $this->render('equipment/create.html.twig', [
                'equipment' => $equipment,
                'equipmentForm' => $equipmentForm->createView()
            ]);
        }
    }

    #[Route('/equipment/list', name: 'equipment_list')]
    public function listEquipment(): Response
    {

        $equipments = $this->equipmentRepository->findAll();

        return $this->render('equipment/listEquipment.html.twig', [
            'equipments' => $equipments,
        ]);
    }

    #[Route('/equipment/detail/{id}', name: 'equipment_detail')]
    public function equipmentDetail(int $id): Response
    {

        $equipment = $this->equipmentRepository->find($id);

        if (!$equipment) {
            throw $this->createNotFoundException("Ooop ! Cette équipment n'existe pas...");
        }

        return $this->render('equipment/equipmentDetail.html.twig', [
            'equipment' => $equipment
        ]);
    }

    #[Route('/equipment/update/{id}', name: 'equipment_update')]
    public function equipmentUpdate(Request $request, int $id): Response
    {
        $equipments = $this->equipmentRepository->findAll();
        $equipment = $this->equipmentRepository->find($id);

        if (!$equipment) {
            throw $this->createNotFoundException("Ooop ! Cette équipment n'existe pas...");
        }

        $equipmentForm = $this->createForm(EquipmentUpdateType::class, $equipment);
        $equipmentForm->handleRequest($request);

        if ($equipmentForm->isSubmitted() && $equipmentForm->isValid()) {
            $this->entityManager->persist($equipment);
            $this->entityManager->flush();
            $this->addFlash("Modification", "Succès de la modification d'un équipement'");

            return $this->redirectToRoute('equipment_list', [
                'equipments' => $equipments
            ]);
        } else {
            return $this->render('equipment/equipmentUpdate.html.twig', [
                'equipmentForm' => $equipmentForm->createView()
            ]);
        }
    }

    #[Route('/equipment/delete/{id}', name: 'equipment_delete')]
    public function equipmentDelete(int $id): Response
    {
        $equipment = $this->equipmentRepository->find($id);

        if (!$equipment) {
            throw $this->createNotFoundException("Ooops ! This serie doesn't esist'");
        }

        $this->entityManager->remove($equipment);
        $this->entityManager->flush();
        $this->addFlash("Suppression", "Equipement supprimé avec succès");

        return $this->redirectToRoute('equipment_list');
    }
}