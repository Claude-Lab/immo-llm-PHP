<?php

namespace App\Form;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CreateUserType extends AbstractType
{

    protected $em;
    protected $repo;

    public function __construct(EntityManagerInterface $em, UserRepository $repo)
    {
        $this->em = $em;
        $this->repo = $repo;
    }
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class, [
                'label'                     => false,
                'required'                  => true,
                'attr'                      => [
                    'placeholder'           => 'Email',
                    'class'                 => 'uk-input'
                ]
            ])
            ->add('firstname', TextType::class, [
                'label'                     => false,
                'required'                  => true,
                'attr'                      => [
                    'placeholder'           => 'Prénom',
                    'class'                 => 'uk-input'
                ]
            ])
            ->add('lastname', TextType::class, [
                'label'                     => false,
                'required'                  => true,
                'attr'                      => [
                    'placeholder'           => 'Nom',
                    'class'                 => 'uk-input'
                ]
            ])
            ->add('mobile', TextType::class, [
                'label'                     => false,
                'required'                  => true,
                'attr'                      => [
                    'placeholder'           => 'Téléphone mobile',
                    'class'                 => 'uk-input all'
                ]
            ])
            ->add('phone', TextType::class, [
                'label'                     => false,
                'required'                  => false,
                'attr'                      => [
                    'placeholder'           => 'Téléphone fixe',
                    'class'                 => 'uk-input all'
                ]
            ])
            ->add('address', AddressType::class, [
                'label'                     => false,
            ])
            ->add('roles', ChoiceType::class, [
                'choices'                   => [
                    '--- Selectionnez le rôle ---' => '',
                    'Locataire'             => 'ROLE_TENANT',
                    'Caution solidaire'     => 'ROLE_GUARANTOR',
                    'Propriétaire'          => 'ROLE_OWNER',
                    'Administrateur'        => 'ROLE_ADMIN',
                ],
                "attr"                      => [
                    'class'                 => 'uk-select'
                ],
                'multiple' => false,
                'expanded' => false,
            ])
            ->add('tenantAddressBefore', AddressType::class, [
                'label'                     => 'Addresse précédant la location',
                'required'                  => false
            ])
            ->add('tenantAddressAfter', AddressType::class, [
                'label'                     => 'Addresse de départ de la location',
                'required'                  => false
            ])
            
        ;

        $builder->get('roles')
            ->addModelTransformer(new CallbackTransformer(
                function ($rolesArray) {
                    return count($rolesArray) ? $rolesArray[0] : null;
                },
                function ($rolesString) {
                    return [$rolesString];
                }
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}