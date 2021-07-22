<?php

namespace App\Controller;

use App\Form\AdminUpdateProfileType;
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


    #[Route('/user/profile', name: 'user_profile')]
    public function editProfile(Request $request,): Response
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
}
