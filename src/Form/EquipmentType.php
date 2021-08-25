<?php

namespace App\Form;

use App\Entity\Equipment;
use App\Entity\State;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EquipmentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label'                     => false,
                'required'                  => true,
                'attr'                      => [
                    'placeholder'           => 'Nom de l\'équipement',
                    'class'                 => 'uk-input'
                ]
            ])
            ->add('brandt', TextType::class, [
                'label'                     => false,
                'required'                  => true,
                'attr'                      => [
                    'placeholder'           => 'Marque',
                    'class'                 => 'uk-input'
                ]
            ])
            ->add('serialNumber', TextType::class, [
                'label'                     => false,
                'required'                  => true,
                'attr'                      => [
                    'placeholder'           => 'Numéro de série',
                    'class'                 => 'uk-input'
                ]
            ])
            ->add('description', TextType::class, [
                'label'                     => false,
                'required'                  => true,
                'attr'                      => [
                    'placeholder'           => 'description',
                    'class'                 => 'uk-input'
                ]
            ])
            ->add('state', EntityType::class, [
                'class'                     => State::class,
                'label'                     => false,
                'placeholder'               => '-- Selectionnez l\'état de l\'appareil --',
                "attr"                      => [
                    'class'                 => 'uk-select',
                ],
                'choice_label'              => 'name',
                'required'                  => true
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Equipment::class,
        ]);
    }
}
