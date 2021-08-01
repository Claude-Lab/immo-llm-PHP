<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\AdminUpdateProfileType;
use App\Form\CreateGuarantorType;
use App\Form\CreateOwnerType;
use App\Form\CreateTenantType;
use App\Form\OwnerUpdateProfileType;
use App\Repository\UserRepository;
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

    public function __construct(EntityManagerInterface $entityManager, 
                                UserRepository $userRepository, 
                                UserPasswordEncoderInterface $passwordEncoder, 
                                UploadProfilePic $uploadProfilePic)
    {
        $this->entityManager    = $entityManager;
        $this->userRepository   = $userRepository;
        $this->passwordEncoder  = $passwordEncoder;
        $this->uploadProfilePic = $uploadProfilePic;
    }

    #[Route('/manage/owner/profile', name: 'user_owner_profile')]
    public function editOwnerProfile(Request $request): Response
    {

        $owner = $this->getUser();
        $ownerId = $owner->getId();
        $owner = $this->userRepository->find($ownerId);
        $userForm = $this->createForm(OwnerUpdateProfileType::class, $owner);
        $userForm->handleRequest($request);

        if ($userForm->isSubmitted() && $userForm->isValid()) {

            $firstPasswordField = $userForm->get('plainPassword')->getData();
            if ($firstPasswordField) {
                $owner->setPassword($this->passwordEncoder->encodePassword($owner,  $firstPasswordField));
            }

            $avatar = $userForm->get('avatar')->getData();
            if ($avatar) {
                $imageDirectory = $this->getParameter('upload_profile_avatar');
                $imageName = $owner->getFirstname() . $owner->getLastname() . $owner->getId();
                $owner->setAvatar($this->uploadProfilePic->save($imageName, $avatar, $imageDirectory));
            }

            $this->entityManager->persist($owner);
            $this->entityManager->flush();
            $this->addFlash("Edition", "Profil édité avec succès");

            return $this->redirectToRoute('dashboard', [
                'owner' => $owner
            ]);
        } else {

            return $this->render('user/editOwnerProfile.html.twig', [
                'owner' => $owner,
                'userForm' => $userForm->createView()
            ]);
        }
    }

    #[Route('/manage/admin/user/profile', name: 'user_admin_profile')]
    public function editProfile(Request $request): Response
    {

        $user = $this->getUser();
        $userId = $user->getId();
        $user = $this->userRepository->find($userId);
        $userForm = $this->createForm(AdminUpdateProfileType::class, $user);
        $userForm->handleRequest($request);

        if ($userForm->isSubmitted() && $userForm->isValid()) {

            $firstPasswordField = $userForm->get('plainPassword')->getData();
            if ($firstPasswordField) {
                $user->setPassword($this->passwordEncoder->encodePassword($user,  $firstPasswordField));
            }

            $avatar = $userForm->get('avatar')->getData();
            if ($avatar) {
                $imageDirectory = $this->getParameter('upload_profile_avatar');
                $imageName = $user->getFirstname() . $user->getLastname() . $user->getId();
                $user->setAvatar($this->uploadProfilePic->save($imageName, $avatar, $imageDirectory));
            }

            $this->entityManager->persist($user);
            $this->entityManager->flush();
            $this->addFlash("Edition", "Profil édité avec succès");

            return $this->redirectToRoute('dashboard', [
                'user' => $user
            ]);
        } else {

            return $this->render('user/editMyProfile.html.twig', [
                'user' => $user,
                'userForm' => $userForm->createView()
            ]);
        }
    }

    

    #[Route('/manage/user/createOwner', name: 'user_create_owner')]
    public function createOwner(Request $request): Response
    {
        $owner = new User();
        $ownerForm = $this->createForm(CreateOwnerType::class, $owner);
        $ownerForm->handleRequest($request);

        if ($ownerForm->isSubmitted() && $ownerForm->isValid()) {

            $password = random_bytes(10);
            $owner->setPassword($this->passwordEncoder->encodePassword($owner,  $password));

            $role = ['ROLE_OWNER'];
            $owner->setRoles($role);

            $this->entityManager->persist($owner);
            $this->entityManager->flush();
            $this->addFlash("Création", "Succès de la création du propriétaire");

            return $this->redirectToRoute('dashboard', [
                'owner' => $owner
            ]);
        } else {

            return $this->render('user/createOwner.html .twig', [
                'owner' => $owner,
                'ownerForm' => $ownerForm->createView()
            ]);
        }
    }

    #[Route('/manage/user/createTenant', name: 'user_create_tenant')]
    public function createTenant(Request $request): Response
    {
        $tenant = new User();
        $tenantForm = $this->createForm(CreateTenantType::class, $tenant);
        $tenantForm->handleRequest($request);

        if ($tenantForm->isSubmitted() && $tenantForm->isValid()) {

            $password = random_bytes(10);
            $tenant->setPassword($this->passwordEncoder->encodePassword($tenant,  $password));

            $role = ['ROLE_TENANT'];
            $tenant->setRoles($role);

            $this->entityManager->persist($tenant);
            $this->entityManager->flush();
            $this->addFlash("Création", "Succès de la création du locataire");

            return $this->redirectToRoute('dashboard', [
                'tenant' => $tenant
            ]);
        } else {

            return $this->render('user/createTenant.html.twig', [
                'tenant' => $tenant,
                'tenantForm' => $tenantForm->createView()
            ]);
        }
    }

    #[Route('/manage/user/createGuarantor', name: 'user_create_guarantor')]
    public function createGuarantor(Request $request): Response
    {
        $guarantor = new User();
        $guarantorForm = $this->createForm(CreateGuarantorType::class, $guarantor);
        $guarantorForm->handleRequest($request);

        if ($guarantorForm->isSubmitted() && $guarantorForm->isValid()) {

            $password = random_bytes(10);
            $guarantor->setPassword($this->passwordEncoder->encodePassword($guarantor,  $password));

            $role = ['ROLE_GUARANTOR'];
            $guarantor->setRoles($role);

            $this->entityManager->persist($guarantor);
            $this->entityManager->flush();
            $this->addFlash("Création", "Succès de la création du guarant");

            return $this->redirectToRoute('dashboard', [
                'guarantor' => $guarantor
            ]);
        } else {

            return $this->render('user/createGuarantor.html.twig', [
                'guarantor' => $guarantor,
                'guarantorForm' => $guarantorForm->createView()
            ]);
        }
    }

    #[Route('/manage/user/listAll', name: 'user_list_all')]
    public function listAllUser(): Response
    {

        $users = $this->userRepository->findAll();

        return $this->render('user/listAllUser.html.twig', [
            'users' => $users,
        ]);
    }

    #[Route('/manage/user/detail/{id}', name: 'user_detail')]
    public function userDetail(int $id): Response
    {

        $user = $this->userRepository->find($id);

        if (!$user) {
            throw $this->createNotFoundException("Ooop ! Cette personne n'existe pas...");
        }

        return $this->render('user/userDetail.html.twig', [
            'user' => $user
        ]);
    }

    // #[Route('/manage/user/createManager', name: 'user_create_manager')]
    // public function createManager(Request $request): Response
    // {
    //     $user = new User();
    //     $userForm = $this->createForm(CreateManagerType::class, $user);
            // $role = ['ROLE_MANAGER'];
            // $guarantor->setRoles($role);

    //     $userForm->handleRequest($request);

    //     if ($userForm->isSubmitted() && $userForm->isValid()) {

    //         $password = random_bytes(10);
    //         $user->setPassword($this->passwordEncoder->encodePassword($user,  $password));

    //         $this->entityManager->persist($user);
    //         $this->entityManager->flush();
    //         $this->addFlash("Création", "Succès de la création de l'utilisateur");

    //         return $this->redirectToRoute('user_list_all', [
    //             'user' => $user
    //         ]);
    //     } else {

    //         return $this->render('user/createUser.html.twig', [
    //             'user' => $user,
    //             'userForm' => $userForm->createView()
    //         ]);
    //     }
    // }


}
