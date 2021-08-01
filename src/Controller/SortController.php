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
    protected $em;
    protected $sortRepository;

    public function __construct(EntityManagerInterface $em, SortRepository $sortRepository)
    {
        $this->em = $em;
        $this->sortRepository = $sortRepository;
    }

    #[Route('/manage/sort/list', name: 'sort_list')]
    public function list(): Response
    {

        $sorts = $this->sortRepository->findall();

        return $this->render('sort/list.html.twig', [
            'sorts' => $sorts,
        ]);
    }

    #[Route('/manage/sort/create', name: 'sort_create')]
    public function create(Request $request): Response
    {

        $sort = new Sort();
        $sortForm = $this->createForm(SortType::class, $sort);
        $sortForm->handleRequest($request);

        if ($sortForm->isSubmitted() && $sortForm->isValid()) {
            $this->em->persist($sort);
            $this->em->flush();
            $this->addFlash("Création", "Succès de la création du type");

            return $this->redirectToRoute('sort_list');
        } else {
            return $this->render('sort/create.html.twig', [
                'sort' => $sort,
                'sortForm' => $sortForm->createView()
            ]);
        }
    }

    #[Route('/manage/sort/edit{id}', name: 'sort_edit')]
    public function detail(Request $request, int $id): Response
    {

        $sort = $this->sortRepository->find($id);
        $sortForm = $this->createForm(SortType::class, $sort);
        $sortForm->handleRequest($request);

        if (!$sort) {
            throw $this->createNotFoundException("Ooops ! Ce type n'existe pas'");
        }
        if ($sortForm->isSubmitted() && $sortForm->isValid()) {
            $this->em->persist($sort);
            $this->em->flush();
            $this->addFlash("Création", "Succès de la modification du type");

            return $this->redirectToRoute('sort_list');
        } else {
            return $this->render('sort/edit.html.twig', [
                'sort' => $sort,
                'sortForm' => $sortForm->createView()
            ]);
        }
    }

    #[Route('/manage/sort/delete/{id}', name: 'sort_delete')]
    public function delete(int $id): Response
    {
        $sort = $this->sortRepository->find($id);

        if (!$sort) {
            throw $this->createNotFoundException("Ooops ! Ce type n'existe pas'");
        }

        $this->em->remove($sort);
        $this->em->flush();

        $this->addFlash("Suppression", "Succès de la suppression du type");
        return $this->redirectToRoute('sort_list');
    }
}
