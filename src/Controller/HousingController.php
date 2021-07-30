<?php

namespace App\Controller;

use App\Entity\Housing;
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


    #[Route('/admin/housing/list', name: 'housing_list_admin')]
    public function listHousings(): Response
    {
        $housings = $this->housingRepository->findall();

        return $this->render('housing/listAdminHousings.html.twig', [
            'housings' => $housings,
        ]);
    }

    #[Route('/housing/createHousing', name: 'housing_create')]
    public function createHousing(Request $request, SortRepository $sortRepository, UserRepository $userRepository, string $role): Response
    {
        $housing = new Housing();

        /*
        * @var string $role
        */
        $role = 'ROLE_OWNER';

        $owner = $userRepository->findByRole($role);
        
        $sort = $sortRepository->findAll();

        $housingForm = $this->createForm(CreateHousingType::class, $housing);
        $housingForm->handleRequest($request);
        

        if ($housingForm->isSubmitted() && $housingForm->isValid()) {

            $this->entityManager->persist($housing);
            $this->entityManager->flush();
            $this->addFlash("Création", "Succès de la création du logement");

            return $this->redirectToRoute('housing_list_admin');

        } else {

            return $this->render('housing/createHousing.html.twig', [
                'housing'       => $housing,
                'owner'         => $owner,
                'sort'          => $sort,
                'housingForm'   => $housingForm->createView()
            ]);
        }
    }

    #[Route('/admin/housing/createHousing', name: 'housing_create_admin')]
    public function adminCreateHousing(Request $request): Response
    {
        $housing = new Housing();
        
        $housingForm = $this->createForm(CreateHousingType::class, $housing);
        $housingForm->handleRequest($request);
        
        if ($housingForm->isSubmitted() && $housingForm->isValid()) {

            $housing->setIsRented(false);
            $this->entityManager->persist($housing);
            $this->entityManager->flush();
            $this->addFlash("Création", "Succès de la création du logement");

            return $this->redirectToRoute('housing_list_admin');
        } else {

            return $this->render('housing/createAdminHousing.html.twig', [
                'housing'               => $housing,
                'housingForm'           => $housingForm->createView()
            ]);
        }
    }

    #[Route('/admin/housing/detail/{id}', name: 'housing_admin_detail')]
    public function housingDetail(int $id): Response
    {
        $housing = $this->housingRepository->find($id);

        return $this->render('housing/detailAdminHousings.html.twig', [
            'housing' => $housing,
        ]);
    }
    
}
