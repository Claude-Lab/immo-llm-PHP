<?php

namespace App\Controller;

use App\Entity\Housing;
use App\Form\CreateHousingType;
use App\Repository\HousingRepository;
use App\Repository\OwnerRepository;
use App\Repository\SortRepository;
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

        return $this->render('housing/listOwnerHousings.html.twig', [
            'housings' => $housings,
        ]);
    }

    #[Route('/manage/housings', name: 'housing_list')]
    public function listAdminHousings(): Response
    {
        $housings = $this->housingRepository->findAll();

        return $this->render('housing/listOwnerHousings.html.twig', [
            'housings' => $housings,
        ]);
    }

    #[Route('/manage/housing/create', name: 'housing_create')]
    public function create(Request $request, SortRepository $typeRepository, OwnerRepository $ownerRepository): Response
    {
        $housing = new Housing();


        $owners = $ownerRepository->findAll();
        $sorts = $typeRepository->findAll();

        $form = $this->createForm(CreateHousingType::class, $housing);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->entityManager->persist($housing);
            $this->entityManager->flush();
            $this->addFlash("Création", "Succès de la création du logement");

            return $this->redirectToRoute('housing_list');
        } else {

            return $this->render('housing/createHousing.html.twig', [
                'housing'       => $housing,
                'form'   => $form->createView()
            ]);
        }
    }

    #[Route('/manage/housing/create', name: 'housing_create')]
    public function createAdminHousing(Request $request, SortRepository $typeRepository): Response
    {
        $housing = new Housing();

        $form = $this->createForm(CreateHousingType::class, $housing);
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

    
}