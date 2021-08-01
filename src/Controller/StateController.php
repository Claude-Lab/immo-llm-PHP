<?php

namespace App\Controller;

use App\Entity\State;
use App\Form\StateType;
use App\Repository\StateRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StateController extends AbstractController
{

    protected $entityManager;
    protected $stateRepository;

    public function __construct(EntityManagerInterface $entityManager, StateRepository $stateRepository)
    {
        $this->entityManager = $entityManager;
        $this->stateRepository = $stateRepository;
    }

    #[Route('/manage/state/list', name: 'state_list')]
    public function list(): Response
    {
        $states = $this->stateRepository->findAll();

        return $this->render('state/list.html.twig', [
            'states' => $states,
        ]);
    }

    #[Route('/manage/state/create', name: 'state_create')]
    public function create(Request $request): Response
    {
        $state = new State();
        $stateForm = $this->createForm(StateType::class, $state);
        $stateForm->handleRequest($request);

        if ($stateForm->isSubmitted() && $stateForm->isValid()) {

            $this->entityManager->persist($state);
            $this->entityManager->flush();
            $this->addFlash("Création", "Succès de la création d'un état");

            return $this->redirectToRoute('state_list');
        } else {

            return $this->render('state/create.html.twig', [
                'state' => $state,
                'stateForm' => $stateForm->createView()
            ]);
        }
    }

    #[Route('/manage/state/delete/{id}', name: 'state_delete')]
    public function delete(int $id): Response
    {
        $state = $this->stateRepository->find($id);

        if (!$state) {
            throw $this->createNotFoundException("Ooops ! This state doesn't esist'");
        }

        $this->entityManager->remove($state);
        $this->entityManager->flush();
        $this->addFlash("Suppression", "Etat supprimé avec succès");

        return $this->redirectToRoute('state_list');
    }

    #[Route('/manage/state/edit/{id}', name: 'state_edit')]
    public function detail(Request $request, int $id): Response
    {
        $state = $this->stateRepository->find($id);
        $stateForm = $this->createForm(StateType::class, $state);
        $stateForm->handleRequest($request);

        if (!$state) {
            throw $this->createNotFoundException("Ooops ! Cet Etat n'existe pas'");
        }
        if ($stateForm->isSubmitted() && $stateForm->isValid()) {
            $this->entityManager->persist($state);
            $this->entityManager->flush();
            $this->addFlash("Création", "Succès de la modification de l'état");

            return $this->redirectToRoute('state_list');
        } else {
            return $this->render('state/edit.html.twig', [
                'state' => $state,
                'stateForm' => $stateForm->createView()
            ]);
        }
    }
}
