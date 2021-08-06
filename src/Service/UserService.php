<?php

namespace App\Service;

use App\Entity\Guarantor;
use App\Entity\Owner;
use App\Entity\Tenant;
use App\Entity\User;
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

                  $password = random_bytes(15);
                  $user->setPassword($this->passwordEncoder->encodePassword($user,  $password));

                  $avatar = 'default.png';

                  $user->setAvatar($avatar);
                  $user->setRoles([$role]);

                  $this->entityManager->persist($user);
                  $this->entityManager->flush();
                  $this->addFlash("success", "Succès de la création de l'utilisateur");

                  return $this->redirectToRoute('users_list');
            } else {
                  if ($entity == Owner::class) {
                        return $this->render('user/owner/create.html.twig', [
                              'user' => $user,
                              'form' => $form->createView()
                        ]);
                  } else if ($entity == Tenant::class) {
                        return $this->render('user/tenant/create.html.twig', [
                              'user' => $user,
                              'form' => $form->createView()
                        ]);
                  } else if ($entity == Guarantor::class) {
                        return $this->render('user/guarantor/create.html.twig', [
                              'user' => $user,
                              'form' => $form->createView()
                        ]);
                  } else {
                        return $this->render('user/admin/create.html.twig', [
                              'user' => $user,
                              'form' => $form->createView()
                        ]);
                  }
            }
      }

      public function userEdit(Request $request, User $user, string $formType): Response
      {

            $form = $this->createForm($formType, $user);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {

                  $this->entityManager->persist($user);
                  $this->entityManager->flush();
                  $fullname = $user->getFullname();
                  $this->addFlash("success", "Compte de \"" . $fullname .  "\" édité avec succès");

                  return $this->redirectToRoute(
                        'user_detail',
                        array('id' => $user->getId())
                  );
            } else {

                  return $this->render('user/edit.html.twig', [
                        'user' => $user,
                        'form' => $form->createView()
                  ]);
            }
      }

      public function profileEdit(Request $request, string $formType): Response
      {

            $user = $this->getUser();
            $form = $this->createForm($formType, $user);
            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {


                  $avatar = $form->get('avatar')->getData();
                  if ($avatar) {
                        $imageDirectory = $this->getParameter('upload_profile_avatar');
                        $imageName = $user->getFirstname() . $user->getLastname() . $user->getId();
                        $user->setAvatar($this->uploadProfilePic->save($imageName, $avatar, $imageDirectory));
                  }

                  $this->entityManager->persist($user);
                  $this->entityManager->flush();
                  $fullname = $user->getFullname();
                  $this->addFlash("success", "Votre compte à été édité avec succès");

                  return $this->redirectToRoute('user_profile');
            } else {

                  return $this->render('user/edit.html.twig', [
                        'user' => $user,
                        'form' => $form->createView()
                  ]);
            }
      }
}
