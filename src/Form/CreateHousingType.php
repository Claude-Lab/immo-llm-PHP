<?php

namespace App\Form;

use App\Entity\Housing;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
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
            ->add('surface')
            ->add('rental')
            ->add('rentalLoad')
            ->add('floor')
            ->add('attic')
            ->add('cellar')
            ->add('pool')
            ->add('box')
            ->add('landSurface')
            ->add('nbFloor')
            ->add('elevator')
            ->add('owner')
            ->add('contract')
            ->add('address')
            ->add('type')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Housing::class,
        ]);
    }
}
