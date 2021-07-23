<?php

namespace App\Controller;

use App\Entity\Housing;
use App\Repository\HousingRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\BrowserKit\Request;
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

    #[Route('/owner/createOHousing', name: 'housing_create')]
    public function createOwner(Request $request): Response
    {
        $housing = new Housing();

        $owner = $this->getUser();
        $ownerId = $owner->getId();

        $housingForm = $this->createForm(CreateHousingType::class, $housing, $ownerId);
        $housingForm->handleRequest($request);

        if ($housingForm->isSubmitted() && $housingForm->isValid()) {

            $this->entityManager->persist($owner);
            $this->entityManager->flush();
            $this->addFlash("Création", "Succès de la création du logement");

            return $this->redirectToRoute('dashboard', [
                'housing' => $housing
            ]);
        } else {

            return $this->render('user/createOwner.html .twig', [
                'housing' => $housing,
                'housingForm' => $housingForm->createView()
            ]);
        }
    }
}
