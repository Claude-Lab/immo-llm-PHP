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
        $this->entityManager        = $entityManager;
        $this->equipmentRepository  = $equipmentRepository;
    }


    #[Route('/manage/equipment/create', name: 'equipment_create')]
    public function create(Request $request): Response
    {
        $equipment = new Equipment();
        $form = $this->createForm(EquipmentType::class, $equipment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


            $this->entityManager->persist($equipment);
            $this->entityManager->flush();
            $this->addFlash("Création", "Succès de la création d'un équipement'");

            return $this->redirectToRoute('equipment_list');
        } else {

            return $this->render('equipment/create.html.twig', [
                'equipment' => $equipment,
                'form'      => $form->createView()
            ]);
        }
    }

    #[Route('/manage/equipments', name: 'equipment_list')]
    public function listEquipment(): Response
    {

        $equipments = $this->equipmentRepository->findAll();

        return $this->render('equipment/list.html.twig', [
            'equipments' => $equipments,
        ]);
    }

    #[Route('/manage/equipment/detail/{id}', name: 'equipment_detail')]
    public function equipmentDetail(int $id): Response
    {
        $equipment = $this->equipmentRepository->find($id);

        if (!$equipment) {
            throw $this->createNotFoundException("Ooop ! Cette équipment n'existe pas...");
        }

        return $this->render('equipment/detail.html.twig', [
            'equipment' => $equipment
        ]);
    }

    #[Route('/manage/equipment/edit/{id}', name: 'equipment_edit')]
    public function equipmentUpdate(Request $request, int $id): Response
    {
        $equipment = $this->equipmentRepository->find($id);

        if (!$equipment) {
            throw $this->createNotFoundException("Ooop ! Cette équipment n'existe pas...");
        }

        $form = $this->createForm(EquipmentType::class, $equipment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($equipment);
            $this->entityManager->flush();
            $this->addFlash("Modification", "Succès de la modification d'un équipement'");

            return $this->redirectToRoute('equipment_list');
        } else {
            return $this->render('equipment/edit.html.twig', [
                'form' => $form->createView()
            ]);
        }
    }

    #[Route('/manage/equipment/delete/{id}', name: 'equipment_delete')]
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