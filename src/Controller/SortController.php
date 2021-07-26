<?php

namespace App\Controller;

use App\Entity\Sort;
use App\Form\SortType;
use App\Repository\SortRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SortController extends AbstractController
{

    protected $entityManager;
    protected $sortRepository;

    public function __construct(EntityManagerInterface $entityManager, SortRepository $sortRepository)
    {
        $this->entityManager = $entityManager;
        $this->sortRepository = $sortRepository;
    }


    #[Route('/sort/list', name: 'sort_list')]
    public function index(): Response
    {

        $sorts = $this->sortRepository->findAll();

        return $this->render('sort/list.html.twig', [
            'sorts'     => $sorts
        ]);
    }

    #[Route('/sort/create', name: 'sort_create')]
    public function createSort(Request $request): Response
    {
        $sort = new Sort();
        $sortForm = $this->createForm(SortType::class, $sort);
        $sortForm->handleRequest($request);

        if ($sortForm->isSubmitted() && $sortForm->isSubmitted()) {
            $this->entityManager->persist($sort);
            $this->entityManager->flush();
            $this->addFlash("Liste", "Succès de la création du type de logement");

            return $this->redirectToRoute('sort_list');
        } else {

            return $this->render('sort/create.html.twig', [
                'sortForm'      => $sortForm->createView(),
                'sort'          => $sort
            ]);
        }
    }

    #[Route('/sort/detail/{id}', name: 'sort_detail')]
    public function detailSort(int $id): Response
    {
        $sort = $this->sortRepository->find($id);

        return $this->render('sort/detail.html.twig', [
            'sort'          => $sort
        ]);
    }
}
