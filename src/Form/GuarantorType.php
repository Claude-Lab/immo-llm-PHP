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

class GuarantorType extends AbstractType
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
            ->add('tenant', EntityType::class, [
                'class'                     => Tenant::class,
                'label'                     => false,
                'placeholder'               => '-- Selectionnez le locataire lié à ce garant--',
                "attr"                      => [
                    'class'                 => 'uk-select',
                ],
                'choice_label'              => 'fullname'
            ])
            ->add('address', AddressType::class, [
                'label'                     => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Guarantor::class,
        ]);
    }
}
