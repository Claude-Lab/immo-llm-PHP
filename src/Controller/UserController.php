<?php

namespace App\Controller;

use App\Data\SearchUsersData;
use App\Entity\Admin;
use App\Entity\Guarantor;
use App\Entity\Owner;
use App\Entity\Tenant;
use App\Form\AdminType;
use App\Form\GuarantorType;
use App\Form\OwnerType;
use App\Form\SearchUsersFormType;
use App\Form\TenantType;
use App\Repository\AdminRepository;
use App\Repository\ContractRepository;
use App\Repository\GuarantorRepository;
use App\Repository\OwnerRepository;
use App\Repository\TenantRepository;
use App\Repository\UserRepository;
use App\Service\UserManager;
use App\Utils\UploadProfilePic;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use MercurySeries\FlashyBundle\FlashyNotifier;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Serializer\SerializerInterface;

class UserController extends AbstractController
{

    protected $entityManager;
    protected $userRepository;
    protected $contractRepository;
    protected $passwordEncoder;
    protected $uploadProfilePic;
    protected $manager;
    protected $ownerRepository;
    protected $tenantRepository;
    protected $guarantorRepository;
    protected $adminRepository;
    protected $flashy;
    protected $serializer;

    public function __construct(
        EntityManagerInterface $entityManager,
        UserRepository $userRepository,
        OwnerRepository $ownerRepository,
        TenantRepository $tenantRepository,
        GuarantorRepository $guarantorRepository,
        AdminRepository $adminRepository,
        ContractRepository $contractRepository,
        UserPasswordEncoderInterface $passwordEncoder,
        UploadProfilePic $uploadProfilePic,
        UserManager $manager,
        FlashyNotifier $flashy,
        SerializerInterface $serializer
    ) {
        $this->entityManager        = $entityManager;
        $this->userRepository       = $userRepository;
        $this->ownerRepository      = $ownerRepository;
        $this->tenantRepository     = $tenantRepository;
        $this->guarantorRepository  = $guarantorRepository;
        $this->adminRepository     = $adminRepository;
        $this->contractRepository   = $contractRepository;
        $this->passwordEncoder      = $passwordEncoder;
        $this->uploadProfilePic     = $uploadProfilePic;
        $this->manager              = $manager;
        $this->flashy               = $flashy;
        $this->$serializer          = $serializer;
    }

    #[Route('/manage/user/create', name: 'create_user')]
    public function createUser()
    {
        return $this->render('user/create.html.twig');
    }


    #[Route('/manage/owner/create', name: 'create_owner')]
    public function createOwner(Request $request)
    {
        $entity     = Owner::class;
        $formType   = OwnerType::class;
        $role       = 'ROLE_OWNER';
        return $this->manager->userCreate($request, $entity, $formType, $role);
    }

    /*
    * @Route("/manage/tenant/create", name="create_tenant" methods={"POST"})
    */
    public function createTenant(Request $request)
    {
        $jsonReceived = $request->getContent();

        $user = $this->serialize->deserialize($jsonReceived, Owner::class, 'json');
        
        # cours : https://www.youtube.com/watch?v=SG7GgcnR1F4&t=458s&ab_channel=LiorCHAMLA


        $entity     = Tenant::class;
        $formType   = TenantType::class;
        $role       = 'ROLE_TENANT';
        return $this->manager->userCreate($request, $entity, $formType, $role);
    }

    #[Route('/manage/guarantor/create', name: 'create_guarantor')]
    public function createGuarantor(Request $request)
    {
        $entity     = Guarantor::class;
        $formType   = GuarantorType::class;
        $role       = 'ROLE_GUARANTOR';
        return $this->manager->userCreate($request, $entity, $formType, $role);
    }

    #[Route('/manage/admin/create', name: 'create_admin')]
    public function createAdmin(Request $request)
    {
        $entity     = Admin::class;
        $formType   = AdminType::class;
        $role       = 'ROLE_ADMIN';
        return $this->manager->userCreate($request, $entity, $formType, $role);
    }

    #[Route('/manage/user/edit/{id}', name: 'user_edit')]
    public function editUser(Request $request, int $id)
    {
        $user = $this->userRepository->find($id);

        switch (true) {
            case ($user instanceof Owner):
                return $this->manager->userEdit($request, $user, OwnerType::class);
                break;
            case ($user instanceof Tenant):
                return $this->manager->userEdit($request, $user, TenantType::class);
                break;
            case ($user instanceof Guarantor):
                return $this->manager->userEdit($request, $user, GuarantorType::class);
                break;
            case ($user instanceof Admin):
                return $this->manager->userEdit($request, $user, AdminType::class);
                break;
        }
    }

    /*
    * @Route("/manage/users", name="users_list" methods={"GET"})
    */
    public function listUsers(Request $request, PaginatorInterface $paginator): Response
    {

        $data = new SearchUsersData();
        $form = $this->createForm(SearchUsersFormType::class, $data);
        $form->handleRequest($request);
        $page = $this->userRepository->SearchUsers($data);
        $users = $paginator->paginate(
            $page,
            $request->query->getInt('page', 1),
            5
        );
        return $this->render('user/users.html.twig', [
            'users'         => $users,
            'form'          => $form->createView(),
        ]);
    }

    /*
    * @Route("/manage/owners", name="owners_list" methods={"GET"})
    */
    public function listOwners(): Response
    {
        $role = 'ROLE_OWNER';

        return $this->json($this->userRepository->findByRole($role), 200, [], ['groups' => 'user:read']);

    }

    #[Route('/manage/tenants', name: 'tenants_list')]
    public function listTenants(): Response
    {
        $role       = 'ROLE_TENANT';
        $users      = $this->userRepository->findByRole($role);

        return $this->render('user/tenant/tenants.html.twig', [
            'users' => $users,
        ]);
    }

    #[Route('/manage/guarantors', name: 'guarantors_list')]
    public function listGuarantors(): Response
    {
        $role       = 'ROLE_GUARANTOR';
        $users      = $this->userRepository->findByRole($role);

        return $this->render('user/guarantor/guarantors.html.twig', [
            'users' => $users,
        ]);
    }

    #[Route('/manage/user/{id}', name: 'user_detail')]
    public function detail(int $id): Response
    {
        /**
         * @var Tenant $user
         */
        $user = $this->userRepository->find($id);

        if (!$user) {
            throw $this->createNotFoundException("Ooop ! Cette personne n'existe pas...");
        }

        if ($user instanceof Tenant) {
            /**
             * @var Contract[] $contracts
             */
            $contracts      = $user->getContracts();
        }

        if ($user instanceof Tenant) {
            return $this->render('user/detail.html.twig', [
                'user'      => $user,
                'contracts' => $contracts
            ]);
        } else {
            return $this->render('user/detail.html.twig', [
                'user'      => $user
            ]);
        }
    }

    #[Route('/profile', name: 'user_profile')]
    public function userProfile(): Response
    {
        $user       = $this->getUser();

        return $this->render('user/profile.html.twig', [
            'user'  => $user
        ]);
    }

    #[Route('/profile/edit', name: 'profile_edit')]
    public function profileEdit(Request $request)
    {
        $role = $this->getUser()->getRoles();

        switch (true) {
            case ($role[0] == 'ROLE_OWNER'):
                return $this->manager->profileEdit($request, OwnerType::class);
                break;
            case ($role[0] == 'ROLE_TENANT'):
                return $this->manager->profileEdit($request, TenantType::class);
                break;
            case ($role[0] == 'ROLE_GUARANTOR'):
                return $this->manager->profileEdit($request, GuarantorType::class);
                break;
            case ($role[0] == 'ROLE_ADMIN'):
                return $this->manager->profileEdit($request, AdminType::class);
                break;
        }
    }

    #[Route('/manage/user/delete/{id}', name: 'user_delete')]
    public function delete(int $id)
    {

        $user = $this->userRepository->find($id);
        $name = $user->getFullname();

        $this->entityManager->remove($user);
        $this->entityManager->flush();
        $this->flashy->success("Le compte de \"" . $name . "\" à été suprimé avec succès");
        return $this->redirectToRoute('users_list');
    }
}
