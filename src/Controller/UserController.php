<?php

namespace App\Controller;

use App\Entity\Guarantor;
use App\Entity\Owner;
use App\Entity\Tenant;
use App\Form\AdminType;
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
        
        switch (true) {
            case ($role[0] == 'ROLE_OWNER'):
                return $this->service->userEdit($request, $user, OwnerType::class);
                break;
            case ($role[0] == 'ROLE_TENANT'):
                return $this->service->userEdit($request, $user, TenantType::class);
                break;
            case ($role[0] == 'ROLE_GUARANTOR'):
                return $this->service->userEdit($request, $user, GuarantorType::class);
                break;
        }
    }

    #[Route('/managment/users', name: 'users_list')]
    public function listAllUsers(): Response
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

    #[Route('/profile', name: 'user_profile')]
    public function userProfile(): Response
    {
        $user = $this->getUser();

        return $this->render('user/profile.html.twig', [
            'user' => $user
        ]);
    }

    #[Route('/profile/edit', name: 'profile_edit')]
    public function profileEdit(Request $request)
    {
        $role = $this->getUser()->getRoles();

        switch (true) {
            case ($role[0] == 'ROLE_OWNER'):
                return $this->service->profileEdit($request, OwnerType::class);
                break;
            case ($role[0] == 'ROLE_TENANT'):
                return $this->service->profileEdit($request, TenantType::class);
                break;
            case ($role[0] == 'ROLE_GUARANTOR'):
                return $this->service->profileEdit($request, GuarantorType::class);
                break;
            case ($role[0] == 'ROLE_ADMIN'):
                return $this->service->profileEdit($request, AdminType::class);
                break;
        }
    }

}
