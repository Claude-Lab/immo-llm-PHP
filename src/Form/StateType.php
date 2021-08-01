<?php

namespace App\Form;

use App\Entity\State;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label'                     => false,
                'required'                  => true,
                'attr'                      => [
                    'placeholder'           => 'Indiquez un libellé pour l\'état',
                    'class'                 => 'uk-input'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => State::class,
        ]);
    }
}
