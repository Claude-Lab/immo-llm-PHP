<?php

namespace App\Form;

use App\Entity\Contract;
use App\Entity\Equipment;
use App\Entity\Housing;
use App\Entity\User;
use App\Repository\ContractRepository;
use App\Repository\EquipmentRepository;
use App\Repository\HousingRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContractType extends AbstractType
{
    protected $em;
    protected $userRepo;
    protected $housingRepo;
    protected $equipmentRepo;
    protected $contractRepo;

    public function __construct(
        EntityManagerInterface $em,
        UserRepository $userRepo,
        HousingRepository $housingRepo,
        EquipmentRepository $equipmentRepo,
        ContractRepository $contractRepo
    ) {
        $this->em = $em;
        $this->userRepo = $userRepo;
        $this->housingRepo = $housingRepo;
        $this->equipmentRepo = $equipmentRepo;
        $this->contractRepo = $contractRepo;
    }



    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $date = new \DateTime('now');

        $builder
            ->add('name', TextType::class, [
                'label'             => false,
                'attr'              => [
                    'placeholder'   => 'Indiquez un nom pour ce contrat',
                    'class'         => 'uk-input'
                ]
            ])
            ->add('rentWithLoad', NumberType::class, [
                'label'             => false,
                'attr'              => [
                    'placeholder'   => 'loyer',
                    'class'         => 'uk-input'
                ]
            ])
            ->add('startDate', DateType::class, [
                'label'             => "Date de début du contrat",
                'widget'            => 'single_text',
                'required'          => true,
                'attr'              => [
                    'class'         => 'uk-input',
                ]
            ])
            ->add('endDate', DateType::class, [
                'label'             => 'Date de fin du contrat',
                'widget'            => 'single_text',
                'required'          => false,
                'attr'              => [
                    'class'         => 'uk-input',
                    'type'          => 'date'
                ]
            ])
            ->add('securityDeposit', NumberType::class, [
                'label'             => 'false',
                'attr'              => [
                    'placeholder'   => 'Dépot de garanty',
                    'class'         => 'uk-input',
                    'type'          => 'number'
                ]
            ])
            ->add('tenants', EntityType::class, [
                'class'             => User::class,
                'mapped'            => false,
                'placeholder'       => '-- Selectionnez le locataire --',
                'label'             => false,
                "attr"              => [
                    'class'         => 'uk-select'
                ],
                'query_builder'     => function () {
                    return $this->userRepo->findByRole('ROLE_TENANT');
                },
                'choice_label'      => 'fullname'
            ])
            ->add('guarantor', EntityType::class, [
                'class'             => User::class,
                'mapped'            => false,
                'placeholder'       => '-- Selectionnez le garant --',
                'label'             => false,
                "attr"              => [
                    'class'         => 'uk-select'
                ],
                'query_builder'     => function () {
                    return $this->userRepo->findByRole('ROLE_GUARANTOR');
                },
                'choice_label'      => 'fullname'
            ])
            ->add('housing', EntityType::class, [
                'class'             => Housing::class,
                'label'             => false,
                'placeholder'       => '-- Selectionnez le logement --',
                "attr"              => [
                    'class'         => 'uk-select'
                ],
                'choice_label'      => 'name'
            ])
            ->add('equipments', EntityType::class, [
                'class'             => Equipment::class,
                'label'             => false,
                'multiple'          => true,
                'expanded'          => true,
                'query_builder'     => function () {
                    return $this->equipmentRepo->findByContract();
                },
                'choice_label'      => function ($equipment) {
                    /** @var Equipment $equipment */
                    return $equipment->getName() . ' / ' . $equipment->getBrandt()  . ' / ' . $equipment->getSerialNumber();
                },
                'attr'              => [
                    'class'         => 'checkboxy',
                ],

            ]);
            
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Contract::class,
        ]);
    }
}
