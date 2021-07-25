<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Image;

class OwnerUpdateProfileType extends AbstractType
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
            ->add('plainPassword', RepeatedType::class, [
                'mapped'                    => false,
                'type'                      => PasswordType::class,
                'required'                  => false,
                'first_options'             => [
                    'label'                 => false,
                    'attr'                      => [
                        'placeholder'           => 'Mot de passe',
                        'class'                 => 'uk-input'
                    ]
                ],
                'second_options'            => [
                    'label'                 => false,
                    'attr'                      => [
                        'placeholder'           => 'Répétez le mot de passe',
                        'class'                 => 'uk-input'
                    ]
                ],
                'invalid_message'           => 'Les deux mots de passe doivent être identiques.',
            ])
            ->add('mobile', TextType::class, [
                'label'                     => false,
                'required'                  => true,
                'attr'                      => [
                    'placeholder'           => 'Téléphone mobile',
                    'class'                 => 'uk-input'
                ]
            ])
            ->add('phone', TextType::class, [
                'label'                     => false,
                'required'                  => false,
                'attr'                      => [
                    'placeholder'           => 'Téléphone fixe',
                    'class'                 => 'uk-input'
                ]
            ])
            ->add('address', AddressType::class, [
                'label'                     => false,
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
            ]);;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
