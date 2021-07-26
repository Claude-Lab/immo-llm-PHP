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


    #[Route('/owner/housings', name: 'housing_list')]
    public function listHousings(): Response
    {
        $owner = $this->getUser();
        $ownerId = $owner->getId();
        $housings = $this->housingRepository->findByOwner($ownerId);

        return $this->render('housing/listOwnerHousings.html.twig', [
            'housings' => $housings,
        ]);
    }

    #[Route('/housing/createHousing', name: 'housing_create')]
    public function createHousing(Request $request, SortRepository $typeRepository, OwnerRepository $ownerRepository): Response
    {
        $housing = new Housing();


        $owners = $ownerRepository->findAll();
        $sorts = $typeRepository->findAll();

        $housingForm = $this->createForm(CreateHousingType::class, $housing);
        $housingForm->handleRequest($request);

        if ($housingForm->isSubmitted() && $housingForm->isValid()) {

            $this->entityManager->persist($housing);
            $this->entityManager->flush();
            $this->addFlash("Création", "Succès de la création du logement");

            return $this->redirectToRoute('housing_list');
        } else {

            return $this->render('housing/createHousing.html.twig', [
                'housing'       => $housing,
                'housingForm'   => $housingForm->createView()
            ]);
        }
    }

    #[Route('/admin/housing/createHousing', name: 'housing_admin_create')]
    public function createAdminHousing(Request $request, SortRepository $typeRepository): Response
    {
        $housing = new Housing();

        $housingForm = $this->createForm(CreateHousingType::class, $housing);
        $housingForm->handleRequest($request);

        if ($housingForm->isSubmitted() && $housingForm->isValid()) {

            $this->entityManager->persist($housing);
            $this->entityManager->flush();
            $this->addFlash("Création", "Succès de la création du logement");

            return $this->redirectToRoute('housing_list');
        } else {

            return $this->render('housing/createHousing.html.twig', [
                'housing'       => $housing,
                'housingForm'   => $housingForm->createView()
            ]);
        }
    }
}