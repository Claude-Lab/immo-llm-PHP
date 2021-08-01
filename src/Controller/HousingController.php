<?php

namespace App\Controller;

use App\Entity\Housing;
use App\Form\HousingType;
use App\Repository\HousingRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HousingController extends AbstractController
{

    protected $entityManager;
    protected $housingRepository;

    public function __construct(EntityManagerInterface $entityManager, HousingRepository $housingRepository)
    {
        $this->entityManager    = $entityManager;
        $this->housingRepository   = $housingRepository;
    }


    #[Route('/manage/housing/list', name: 'housing_list')]
    public function listHousings(): Response
    {
        $housings = $this->housingRepository->findall();

        return $this->render('housing/list.html.twig', [
            'housings' => $housings,
        ]);
    }

    #[Route('/manage/housing/create', name: 'housing_create')]
    public function create(Request $request): Response
    {
        $housing = new Housing();
        
        $housingForm = $this->createForm(HousingType::class, $housing);
        $housingForm->handleRequest($request);
        
        if ($housingForm->isSubmitted() && $housingForm->isValid()) {

            $this->entityManager->persist($housing);
            $this->entityManager->flush();
            $this->addFlash("Création", "Succès de la création du logement");

            return $this->redirectToRoute('housing_list');
        } else {

            return $this->render('housing/create.html.twig', [
                'housing'               => $housing,
                'housingForm'           => $housingForm->createView()
            ]);
        }
    }

    #[Route('/manage/housing/detail/{id}', name: 'housing_detail')]
    public function detail(int $id): Response
    {
        $housing = $this->housingRepository->find($id);

        return $this->render('housing/detail.html.twig', [
            'housing' => $housing,
        ]);
    }

    #[Route('/manage/housing/edit/{id}', name: 'housing_edit')]
    public function edit(Request $request, int $id): Response
    {
        $housing = $this->housingRepository->find($id);

        $housingForm = $this->createForm(HousingType::class, $housing);
        $housingForm->handleRequest($request);

        if ($housingForm->isSubmitted() && $housingForm->isValid()) {

            $this->entityManager->persist($housing);
            $this->entityManager->flush();
            $this->addFlash("Edition", "Succès de l\'édition du logement");

            return $this->redirectToRoute('housing_list');
        } else {

            return $this->render('housing/edit.html.twig', [
                'housing'               => $housing,
                'housingForm'           => $housingForm->createView()
            ]);
        }
    }
    
}
