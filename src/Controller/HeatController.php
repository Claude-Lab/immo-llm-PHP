<?php

namespace App\Controller;

use App\Entity\Heat;
use App\Form\HeatType;
use App\Repository\HeatRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HeatController extends AbstractController
{
    protected EntityManagerInterface $entityManager;
    protected HeatRepository $repository;

    public function __construct(EntityManagerInterface $entityManager, HeatRepository $repository)
    {
        $this->entityManager = $entityManager;
        $this->repository = $repository;
    }

    #[Route('/manage/heat/create', name: 'heat_create')]
    public function create(Request $request): Response
    {
        $heat = new Heat();
        $form = $this->createForm(HeatType::class, $heat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->entityManager->persist($heat);
            $this->entityManager->flush();
            $this->addFlash("Création", "Succès de la création d'un système de chauffage'");

            return $this->redirectToRoute('heat_list');
        } else {

            return $this->render('heat/create.html.twig', [
                'heat' => $heat,
                'equipmentForm' => $form->createView()
            ]);
        }
    }

    #[Route('/manage/heats', name: 'heat_list')]
    public function list(): Response
    {
        $heats = $this->repository->findAll();

        return $this->render('heat/list.html.twig', [
            'heats' => $heats,
        ]);
    }

    #[Route('/manage/heat/{id}', name: 'heat_detail')]
    public function detail(int $id): Response
    {

        $heat = $this->repository->find($id);

        if (!$heat) {
            throw $this->createNotFoundException("Ooop ! Ce système de chauffage n'existe pas...");
        }

        return $this->render('heat/detail.html.twig', [
            'heat' => $heat
        ]);
    }

    #[Route('/manage/heat/edit/{id}', name: 'heat_edit')]
    public function edit(Request $request, int $id): Response
    {
        $heat = $this->repository->find($id);

        if (!$heat) {
            throw $this->createNotFoundException("Ooop ! Ce un système de chauffage n'existe pas...");
        }

        $form = $this->createForm(HeatType::class, $heat);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($heat);
            $this->entityManager->flush();
            $this->addFlash("Modification", "Succès de la modification du système de chauffage'");

            return $this->redirectToRoute('heat_list');
        } else {
            return $this->render('heat/edit.html.twig', [
                'form' => $form->createView()
            ]);
        }
    }

    #[Route('/manage/heat/delete/{id}', name: 'heat_delete')]
    public function delete(int $id): Response
    {
        $heat = $this->repository->find($id);

        if (!$heat) {
            throw $this->createNotFoundException("Ooop ! Ce un système de chauffage n'existe pas...'");
        }

        $this->entityManager->remove($heat);
        $this->entityManager->flush();
        $this->addFlash("Suppression", "Système de chauffage supprimé avec succès");

        return $this->redirectToRoute('heat_list');
    }


}
