<?php

namespace App\Controller;

use App\Entity\Sort;
use App\Form\SortType;
use App\Repository\SortRepository;
use Doctrine\ORM\EntityManagerInterface;
use MercurySeries\FlashyBundle\FlashyNotifier;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SortController extends AbstractController
{

    protected $entityManager;
    protected $sortRepository;
    protected $flashy;

    public function __construct(EntityManagerInterface $entityManager, 
                                SortRepository $sortRepository,
                                FlashyNotifier $flashy)
    {
        $this->entityManager    = $entityManager;
        $this->sortRepository   = $sortRepository;
        $this->flashy           = $flashy;
    }


    #[Route('/manage/sort/list', name: 'sort_list')]
    public function list(): Response
    {

        $sorts = $this->sortRepository->findAll();

        return $this->render('sort/list.html.twig', [
            'sorts'     => $sorts
        ]);
    }

    #[Route('/manage/sort/create', name: 'sort_create')]
    public function create(Request $request): Response
    {
        $sort = new Sort();
        $form = $this->createForm(SortType::class, $sort);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isSubmitted()) {
            $this->entityManager->persist($sort);
            $this->entityManager->flush();
            $this->flashy->success("Succès de la création du type de logement");

            return $this->redirectToRoute('sort_list');
        } else {

            return $this->render('sort/create.html.twig', [
                'form'      => $form->createView(),
                'sort'      => $sort
            ]);
        }
    }

    #[Route('/manage/sort/edit/{id}', name: 'sort_edit')]
    public function edit(Request $request, int $id): Response
    {
        $sort = $this->sortRepository->find($id);
        $form = $this->createForm(SortType::class, $sort);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isSubmitted()) {
            $this->entityManager->persist($sort);
            $this->entityManager->flush();
            $this->flashy->success("Succès de la modification du type de logement");

            return $this->redirectToRoute('sort_list');
        } else {

            return $this->render('sort/create.html.twig', [
                'form'      => $form->createView(),
                'sort'      => $sort
            ]);
        }
    }

    #[Route('/manage/sort/delete/{id}', name: 'sort_delete')]
    public function delete(int $id): Response
    {
        $sort = $this->sortRepository->find($id);

        $this->entityManager->remove($sort);
        $this->entityManager->flush();

        $this->flashy->success("Type de logement supprimé avec succès");

        return $this->redirectToRoute('sort_list');
    }
}
