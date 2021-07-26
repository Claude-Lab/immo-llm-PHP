<?php

namespace App\Controller;

use App\Entity\Housing;
use App\Entity\User;
use App\Form\CreateHousingType;
use App\Repository\HousingRepository;
use App\Repository\SortRepository;
use App\Repository\UserRepository;
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
    public function createHousing(Request $request, SortRepository $typeRepository, UserRepository $userRepository, string $role): Response
    {
        $housing = new Housing();

        $role = 'ROLE_OWNER';

        $owners = $userRepository->findByRoles($role);
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
                'owners'        => $owners,
                'sorts'         => $sorts,
                'housingForm'   => $housingForm->createView()
            ]);
        }
    }
}