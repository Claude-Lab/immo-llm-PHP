<?php

namespace App\Service;

use App\Entity\Admin;
use App\Entity\Guarantor;
use App\Entity\Owner;
use App\Entity\Tenant;
use App\Entity\User;
use App\Utils\UploadProfilePic;
use Doctrine\ORM\EntityManagerInterface;
use MercurySeries\FlashyBundle\FlashyNotifier;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserManager extends AbstractController
{

      protected $entityManager;
      protected $passwordEncoder;
      protected $uploadProfilePic;
      protected $flashy;


      public function __construct(
            EntityManagerInterface $entityManager,
            UserPasswordEncoderInterface $passwordEncoder,
            UploadProfilePic $uploadProfilePic,
            FlashyNotifier $flashy,
      ) {
            $this->entityManager    = $entityManager;
            $this->passwordEncoder  = $passwordEncoder;
            $this->uploadProfilePic = $uploadProfilePic;
            $this->flashy           = $flashy;
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

                  switch ($entity) {
                        case ($entity == Owner::class):
                              return $this->render('user/owner/create.html.twig', [
                                    'user' => $user,
                                    'form' => $form->createView()
                              ]);
                              break;
                        case ($entity == Tenant::class):
                              return $this->render('user/tenant/create.html.twig', [
                                    'user' => $user,
                                    'form' => $form->createView()
                              ]);
                              break;
                        case ($entity == Guarantor::class):
                              return $this->render('user/guarantor/create.html.twig', [
                                    'user' => $user,
                                    'form' => $form->createView()
                              ]);
                              break;
                        case ($entity == Admin::class):
                              return $this->render('user/admin/create.html.twig', [
                                    'user' => $user,
                                    'form' => $form->createView()
                              ]);
                              break;
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
                  $this->addFlash("success", "Compte de \"" . $user->getFullname() .  "\" édité avec succès");

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
                  $this->flashy->success('Votre compte ' . $fullname . ' à été édité avec succès', 'http://claude-lusseau.fr');

                  return $this->redirectToRoute('user_profile');
            } else {

                  return $this->render('user/edit.html.twig', [
                        'user' => $user,
                        'form' => $form->createView()
                  ]);
            }
      }
}
