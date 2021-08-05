<?php

namespace App\Service;

use App\Repository\UserRepository;
use App\Utils\UploadProfilePic;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserService extends AbstractController
{

      protected $entityManager;
      protected $userRepository;
      protected $passwordEncoder;
      protected $uploadProfilePic;

      public function __construct(
            EntityManagerInterface $entityManager,
            UserRepository $userRepository,
            UserPasswordEncoderInterface $passwordEncoder,
            UploadProfilePic $uploadProfilePic,
      ) {
            $this->entityManager    = $entityManager;
            $this->userRepository   = $userRepository;
            $this->passwordEncoder  = $passwordEncoder;
            $this->uploadProfilePic = $uploadProfilePic;
      }

      public function userCreate(Request $request, string $entity, string $formType, string $role): Response
      {
            $user = new $entity;
            $form = $this->createForm($formType, $user);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {

                  $password = random_bytes(10);
                  $user->setPassword($this->passwordEncoder->encodePassword($user,  $password));

                  $avatar = 'default.png';

                  $user->setAvatar($avatar);
                  $user->setRoles([$role]);

                  $this->entityManager->persist($user);
                  $this->entityManager->flush();
                  $this->addFlash("success", "Succès de la création de l'utilisateur");

                  return $this->redirectToRoute('users_list');
            } else {
                  return $this->render('user/owner/create.html.twig', [
                        'user' => $user,
                        'form' => $form->createView()
                  ]);
            }
      }

      public function userEdit(Request $request, int $id, string $formType)
      {
            $user = $this->userRepository->find($id);

            $form = $this->createForm($formType, $user);
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
                  $this->addFlash("success", "Utilisateur édité avec succès");

                  return $this->redirectToRoute('users_list');
            } else {

                  return $this->render('user/edit.html.twig', [
                        'user' => $user,
                        'form' => $form->createView()
                  ]);
            }
      }
}
