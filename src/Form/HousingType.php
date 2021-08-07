<?php

namespace App\Form;

use App\Entity\Heat;
use App\Entity\Housing;
use App\Entity\Sort;
use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HousingType extends AbstractType
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
            ->add('name', TextType::class, [
                'label'             => 'Nom du logement',
                'attr'              => [
                    'placeholder'   => 'Indiquez un nom pour ce logement (résidence, propiétaire, etc.)',
                    'class'         => 'uk-input'
                ]
            ])
            ->add('nbRoom', IntegerType::class, [
                'label'             => 'Nombre de pièces',
                'attr'              => [
                    'placeholder'   => 'Nombre de pièces',
                    'class'         => 'uk-input'
                ]
            ])
            ->add('surface', NumberType::class, [
                'label'             => 'Surface totale',
                'attr'              => [
                    'placeholder'   => 'Surface totale',
                    'class'         => 'uk-input'
                ]
            ])
            ->add('floor', IntegerType::class, [
                'label'             => 'Etage',
                'required'          => false,
                'attr'              => [
                    'placeholder'   => 'Etage',
                    'class'         => 'uk-input'
                ],
                'required'          => false
            ])
            ->add('attic', CheckboxType::class, [
                'label'             => 'Grenier',
                'attr'              => [
                    'type'          => 'checkbox',
                    'class'         => 'uk-checkbox'
                ],
                'required'          => false
            ])
            ->add('cellar', CheckboxType::class, [
                'label'             => 'Cave',
                'attr'              => [
                    'type'          => 'checkbox',
                    'class'         => 'uk-checkbox'
                ],
                'required'          => false
            ])
            ->add('pool', CheckboxType::class, [
                'label'             => 'Piscine',
                'attr'              => [
                    'type'          => 'checkbox',
                    'class'         => 'uk-checkbox'
                ],
                'required'          => false
            ])
            ->add('box', CheckboxType::class, [
                'label'             => 'Garage',
                'attr'              => [
                    'type'          => 'checkbox',
                    'class'         => 'uk-checkbox'
                ],
                'required'          => false
            ])
            ->add('landSurface', NumberType::class, [
                'label'             => 'Surface de terrain',
                'attr'              => [
                    'placeholder'   => 'Surface de terrain',
                    'class'         => 'uk-input'
                ],
                'required'          => false,
            ])
            ->add('nbLevel', IntegerType::class, [
                'label'             => 'Nombre de niveaux (étages)',
                'attr'              => [
                    'placeholder'   => 'Nombre de niveaux (étages)',
                    'class'         => 'uk-input'
                ],
                'required'          => false,
            ])
            ->add('elevator', CheckboxType::class, [
                'label'             => 'Ascenceur',
                'attr'              => [
                    'type'          => 'checkbox',
                    'class'         => 'uk-checkbox',
                    'margin-right'  => '3px'
                ],
                'required'          => false
            ])
            ->add('owner', EntityType::class, [
                'class'             => User::class,
                'label'             => false,
                'placeholder'       => '-- Selectionnez le propriétaire --',
                "attr"              => [
                    'class'         => 'uk-select',
                ],
                'query_builder'     => function () {
                    return $this->repo->searchByOwner();
                },
                'choice_label'      => 'fullname'
            ])
            ->add('address', AddressType::class, [
                'label'             => false
            ])
            ->add('sort', EntityType::class, [
                'placeholder'       => '-- Selectionnez le type de logement --',
                'label'             => false,
                'class'             => Sort::class,
                "attr"              => [
                    'class'         => 'uk-select',
                ],
                'choice_label'      => 'name'
            ])
            ->add('heat', EntityType::class, [
                'placeholder'       => '-- Selectionnez le type de chauffage --',
                'label'             => false,
                'class'             => Heat::class,
                "attr"              => [
                    'class'         => 'uk-select',
                ],
                'choice_label'      =>
                function (Heat $heat) {
                    return $heat->getName() . ' - ' . $heat->getFacilitie();
                },
            ])
            /* ->add('photos', FileType::class, [
                'mapped'                    => false,
                'required'                  => false,
                'label'                     => false,
                'constraints'               => [
                    new Image([
                        'maxSize'           => '7000k',
                        'mimeTypesMessage'  => "Format d'image non autorisé"
                    ])

                ]
            ]) */
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Housing::class,
        ]);
    }
}
