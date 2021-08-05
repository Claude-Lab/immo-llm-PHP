<?php

namespace App\Form;

use App\Entity\Guarantor;
use App\Entity\Tenant;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Image;

class TenantType extends AbstractType
{
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
            
            ->add('addressBefore', AddressType::class, [
                'label'                     => 'Addresse précédant la location',
                'required'                  => false
            ])
            ->add('addressAfter', AddressType::class, [
                'label'                     => 'Addresse précédant la location',
                'required'                  => false
            ])
            ->add('guarantor', EntityType::class, [
                'class'                     => Guarantor::class,
                'label'                     => false,
                'placeholder'               => '-- Selectionnez le guarant du locataire --',
                "attr"                      => [
                    'class'                 => 'uk-select',
                ],
                'choice_label'              => 'fullname'
            ])
            ->add('avatar', FileType::class, [
                'mapped'                    => false,
                'required'                  => false,
                'label'                     => false,
                'constraints'               => [
                    new Image([
                        'maxSize'           => '7000k',
                        'mimeTypesMessage'  => "Format d'image non autorisé"
                    ])

                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Tenant::class,
        ]);
    }
}