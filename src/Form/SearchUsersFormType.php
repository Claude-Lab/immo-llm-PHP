<?php

namespace App\Form;

use App\Data\SearchUsersData;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SearchUsersFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            // Name filter :
            ->add('fullname', TextType::class, [
                'label'             => false,
                'required'          => false,
            ])
            ->add('tenants', CheckboxType::class, [
                'label'             => 'Locataires',
                'attr'              => [
                    'type'          => 'checkbox label'
                ],
                'required'          => false
            ])
            ->add('owners', CheckboxType::class, [
                'label'             => 'Propriétaires',
                'attr'              => [
                    'type'          => 'checkbox label'
                ],
                'required'          => false
            ])
            ->add('guarantors', CheckboxType::class, [
                'label'             => 'Garants',
                'attr'              => [
                    'type'          => 'checkbox label'
                ],
                'required'          => false
            ])
            ->add('managers', CheckboxType::class, [
                'required'          => false,
                'label'             => 'Managers',
                'attr'              => [
                    'type'              => 'checkbox label'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SearchUsersData::class,
            'method' => 'GET',
            'csrf_protection' => false
        ]);
    }

    public function getBlockPrefix(): string
    {
        return '';
    }
}
