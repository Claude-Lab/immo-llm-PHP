<?php

namespace App\Form;

use App\Entity\Equipment;
use App\Entity\Housing;
use App\Entity\State;
use App\Repository\EquipmentRepository;
use Doctrine\DBAL\Types\BooleanType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EquipmentType extends AbstractType
{
    protected $repo;

    public function __construct(EquipmentRepository $repo)
    {
        $this->repo = $repo;
    }

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
            ->add('serialNumber', TextType::class, [
                'label'                     => false,
                'required'                  => false,
                'attr'                      => [
                    'placeholder'           => 'Numéro de série',
                    'class'                 => 'uk-input'
                ]
            ])
            ->add('description', TextareaType::class, [
                'label'                     => false,
                'required'                  => false,
                'attr'                      => [
                    'placeholder'           => 'Indiquez l\'état de l\'équipement)',
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
            ->add('state', EntityType::class, [
                'placeholder'       => '-- Selectionnez l\'état de l\'appareil --',
                'label'             => false,
                'class'             => State::class,
                "attr"              => [
                    'class'         => 'uk-select',
                ],
                'choice_label'      => 'name',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Equipment::class,
        ]);
    }
}
