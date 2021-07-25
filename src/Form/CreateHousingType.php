<?php

namespace App\Form;

use App\Entity\Housing;
use Doctrine\DBAL\Types\BooleanType;
use Doctrine\DBAL\Types\IntegerType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CreateHousingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nbRoom', IntegerType::class, [
                'label'             => false
            ])
            ->add('surface', NumberType::class, [
                'label'             => false
            ])
            ->add('rental', NumberType::class, [
                'label'             => false
            ])
            ->add('rentalLoad', NumberType::class, [
                'label'             => false
            ])
            ->add('floor', IntegerType::class, [
                'label'             => false
            ])
            ->add('attic', BooleanType::class, [
                'label'             => false
            ])
            ->add('cellar', BooleanType::class, [
                'label'             => false
            ])
            ->add('pool', BooleanType::class, [
                'label'             => false
            ])
            ->add('box', BooleanType::class, [
                'label'             => false
            ])
            ->add('landSurface', NumberType::class, [
                'label'             => false
            ])
            ->add('nbFloor', IntegerType::class, [
                'label'             => false
            ])
            ->add('elevator', BooleanType::class, [
                'label'             => false
            ])
            ->add('owner', EntityType::class, [
                'label'             => false,
                'class'             => User::class,
                'choice_label'      => 'firstname' . ' ' . 'lastname'
            ])
            ->add('contract', EntityType::class, [
                'label'             => false,
                'class'             => ContractType::class,
                'choice_label'      => 'id'
            ])
            ->add('address', AddressType::class, [
                'label'             => false
            ])
            ->add('type', EntityType::class, [
                'label'             => false,
                'class'             => HousingType::class,
                'choice_label'      => 'name'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Housing::class,
        ]);
    }
}