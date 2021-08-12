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

    #[Route('/manage/owner/housings', name: 'owner_housings')]
    public function listHousings(): Response
    {
        $owner = $this->getUser();
        $id = $owner->getId();
        $housings = $this->housingRepository->findByOwner($id);

        return $this->render('housing/list.html.twig', [
            'housings' => $housings,
        ]);
    }

    #[Route('/manage/housings', name: 'housing_list')]
    public function listAdminHousings(): Response
    {
        $housings = $this->housingRepository->findAll();

        return $this->render('housing/list.html.twig', [
            'housings' => $housings,
        ]);
    }


    #[Route('/manage/housing/create', name: 'housing_create')]
    public function createAdminHousing(Request $request): Response
    {
        $housing = new Housing();

        $form = $this->createForm(HousingType::class, $housing);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->entityManager->persist($housing);
            $this->entityManager->flush();
            $this->addFlash("Création", "Succès de la création du logement");

            return $this->redirectToRoute('housing_list');
        } else {

            return $this->render('housing/create.html.twig', [
                'housing'       => $housing,
                'form'          => $form->createView()
            ]);
        }
    }

    #[Route('/manage/housing/detail/{id}', name: 'housing_detail')]
    public function detail(int $id): Response
    {
        $housing = $this->housingRepository->find($id);

        return $this->render('housing/detail.html.twig', [
            'housing'       => $housing,
        ]);
    }

    #[Route('/manage/housing/edit/{id}', name: 'housing_edit')]
    public function edit(Request $request, int $id): Response
    {
        $housing = $this->housingRepository->find($id);
        
        $form = $this->createForm(HousingType::class, $housing);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->entityManager->persist($housing);
            $this->entityManager->flush();
            $this->addFlash("Edition", "Succès de l\'édition du logement");

            return $this->redirectToRoute(
                'housing_detail',
                ['id' => $housing->getId()]
            );
        } else {

            return $this->render('housing/edit.html.twig', [
                'housing'   => $housing,
                'form'      => $form->createView()
            ]);
        }
    }
}
