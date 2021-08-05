<?php

namespace App\Controller;

use App\Entity\Guarantor;
use App\Entity\Owner;
use App\Entity\Tenant;
use App\Form\GuarantorType;
use App\Form\OwnerType;
use App\Form\OwnerUpdateProfileType;
use App\Form\TenantType;
use App\Repository\UserRepository;
use App\Service\UserService;
use App\Utils\UploadProfilePic;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends AbstractController
{

    protected $entityManager;
    protected $userRepository;
    protected $passwordEncoder;
    protected $uploadProfilePic;
    protected $service;

    public function __construct(
        EntityManagerInterface $entityManager,
        UserRepository $userRepository,
        UserPasswordEncoderInterface $passwordEncoder,
        UploadProfilePic $uploadProfilePic,
        UserService $service
    ) {
        $this->entityManager    = $entityManager;
        $this->userRepository   = $userRepository;
        $this->passwordEncoder  = $passwordEncoder;
        $this->uploadProfilePic = $uploadProfilePic;
        $this->service          = $service;
    }

    #[Route('/managment/owner/create', name: 'create_owner')]
    public function createUser(Request $request)
    {
        $entity = Owner::class;
        $formType = OwnerType::class;
        $role = 'ROLE_OWNER';
        $this->sercive->userCreate($request, $entity, $formType, $role);
    }

    #[Route('/managment/tenant/create', name: 'create_tenant')]
    public function createTenant(Request $request)
    {
        $entity = Tenant::class;
        $formType = TenantType::class;
        $role = 'ROLE_TENANT';
        $this->service->userCreate($request, $entity, $formType, $role);
    }

    #[Route('/managment/guarantor/create', name: 'create_guarantor')]
    public function createGuarantor(Request $request)
    {
        $entity = Guarantor::class;
        $formType = GuarantorType::class;
        $role = 'ROLE_GUARANTOR';
        $this->service->userCreate($request, $entity, $formType, $role);
    }
    
    #[Route('/managment/user/edit/{id}', name: 'user_edit')]
    public function editUser(Request $request, int $id)
    {
        $user = $this->userRepository->find($id);
        $role = $user->getRoles();
        

        if ($role = ['ROLE_OWNER']) {
            return $this->service->userEdit($request, $id, OwnerType::class);
        } else if ($role = ['ROLE_TENANT']) {
            return $this->service->userEdit($request, $id, TenantType::class);
        } else if ($role = ['ROLE_GUARANTOR']) {
            return $this->service->userEdit($request, $id, GuarantorType::class);
        }

    }

    #[Route('/profile', name: 'user_profile')]
    public function editProfile(Request $request): Response
    {

        $user = $this->getUser();
        $userId = $user->getId();
        $user = $this->userRepository->find($userId);
        $form = $this->createForm(OwnerUpdateProfileType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $firstPasswordField = $form->get('plainPassword')->getData();
            if ($firstPasswordField) {
                $user->setPassword($this->passwordEncoder->encodePassword($user,  $firstPasswordField));
            }

            $avatar = $form->get('avatar')->getData();
            if ($avatar) {
                $imageDirectory = $this->getParameter('upload_profile_avatar');
                $imageName = $user->getFirstname() . $user->getLastname() . $user->getId();
                $user->setAvatar($this->uploadProfilePic->save($imageName, $avatar, $imageDirectory));
            }

            $this->entityManager->persist($user);
            $this->entityManager->flush();
            $this->addFlash("Edition", "Profil édité avec succès");

            return $this->redirectToRoute('dashboard');
        } else {

            return $this->render('user/editOwnerProfile.html.twig', [
                'user' => $user,
                'form' => $form->createView()
            ]);
        }
    }

    #[Route('/managment/users', name: 'users_list')]
    public function listAllUser(): Response
    {
        $users = $this->userRepository->findAll();

        return $this->render('user/list.html.twig', [
            'users' => $users,
        ]);
    }

    #[Route('/managment/user/{id}', name: 'user_detail')]
    public function detail(int $id): Response
    {
        $user = $this->userRepository->find($id);

        if (!$user) {
            throw $this->createNotFoundException("Ooop ! Cette personne n'existe pas...");
        }

        return $this->render('user/detail.html.twig', [
            'user' => $user
        ]);
    }

}
