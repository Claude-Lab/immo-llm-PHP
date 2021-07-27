<?php

namespace App\Form;

use App\Entity\Housing;
use App\Entity\Owner;
use App\Entity\Sort;
use App\Entity\User;
use App\Repository\OwnerRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CreateHousingType extends AbstractType
{
    protected $ownerRepository;
    protected $userRepository;
    protected $entityManager;

    public function __construct(OwnerRepository $ownerRepository, UserRepository $userRepository, EntityManagerInterface $entityManager)
    {
        $this->ownerRepository = $ownerRepository;
        $this->userRepository = $userRepository;
        $this->entityManager = $entityManager;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        parent::buildForm($builder, $options);


        $builder
            ->add('nbRoom', IntegerType::class, [
                'label'             => false,
                'attr'              => [
                    'placeholder'   => 'Nombre de pièces',
                    'class'         => 'uk-input'
                ]
            ])
            ->add('surface', NumberType::class, [
                'label'             => false,
                'attr'              => [
                    'placeholder'   => 'Surface totale',
                    'class'         => 'uk-input'
                ]
            ])
            ->add('rental', NumberType::class, [
                'label'             => false,
                'attr'              => [
                    'placeholder'   => 'Loyer hors charges',
                    'class'         => 'uk-input'
                ]
            ])
            ->add('housingLoad', NumberType::class, [
                'label'             => false,
                'attr'              => [
                    'placeholder'   => 'Charges',
                    'class'         => 'uk-input'
                ]
            ])
            ->add('floor', IntegerType::class, [
                'label'             => false,
                'required'          => false,
                'attr'              => [
                    'placeholder'   => 'Etage',
                    'class'         => 'uk-input'
                ]
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
                'label'             => false,
                'attr'              => [
                    'placeholder'   => 'Surface de terrain',
                    'class'         => 'uk-input'
                ],
                'required'          => false,
            ])
            ->add('nbFloor', IntegerType::class, [
                'label'             => false,
                'attr'              => [
                    'placeholder'   => 'Nombre de niveaux (étages)',
                    'class'         => 'uk-input'
                ]
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
            ->add('address', AddressType::class, [
                'label'             => false
            ])
            ->add('sort', EntityType::class, [
                'label'             => 'Selectionnez le type de logement',
                'class'             => Sort::class,
                "attr"              => [
                    'class'         => 'uk-select'
                ],
                'choice_label'      => 'name',
            ])
            ->add('owner', EntityType::class, [
                'class'             => Owner::class,
                'mapped'            => false,
                'label'             => 'Selectionnez le propriétaire',
                'query_builder'     => function (OwnerRepository $repository) {
                    return $repository->findByOwner();
                        
                },
                "attr"              => [
                    'class'         => 'uk-select'
                ],
                'choice_label'      => 'owner'

            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Housing::class,
        ]);
    }
}
