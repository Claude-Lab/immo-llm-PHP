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
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContractType extends AbstractType
{
    protected $em;
    protected $userRepo;
    protected $equipmentRepo;
    protected $contractRepo;
    protected $housingRepo;

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
            ->add('rent', NumberType::class, [
                'label'             => false,
                'attr'              => [
                    'placeholder'   => 'loyer hors charges',
                    'class'         => 'uk-input'
                ]
            ])
            ->add('rentLoad', NumberType::class, [
                'label'             => false,
                'attr'              => [
                    'placeholder'   => 'charges',
                    'class'         => 'uk-input'
                ]
            ])
            ->add('startDate', DateType::class, [
                'label'             => "Date de d??but du contrat",
                'widget'            => 'single_text',
                'required'          => true,
                'attr'              => [
                    'class'         => 'uk-input',
                    'type'          => 'date'
                ]
            ])
            ->add('endDate', DateType::class, [
                'label'             => 'Date de fin du contrat',
                'widget'            => 'single_text',
                'attr'              => [
                    'class'         => 'uk-input',
                    'type'          => 'date'
                ]
            ])
            ->add('securityDeposit', NumberType::class, [
                'label'             => 'false',
                'attr'              => [
                    'placeholder'   => 'D??pot de garanty',
                    'class'         => 'uk-input',
                    'type'          => 'number'
                ]
            ])
            ->add('tenants', EntityType::class, [
                'class'             => User::class,
                'choice_label'      => 'fullname',
                'multiple'          => true,
                'placeholder'       => '-- Selectionnez le ou les locataires --',
                "attr"              => [
                    'class'         => 'uk-select select-tenants',
                ],
                'query_builder'     => function () {
                    return $this->userRepo->searchByTenant();
                }
            ])
            ->add('equipments', EntityType::class, [
                'class'             => Equipment::class,
                'label'             => false,
                'multiple'          => true,
                'placeholder'       => '-- Selectionnez le ou les ??quipements --',
                'choice_label'      => function ($equipment) {
                    /** @var Equipment $equipment */
                    return $equipment->getName() . ' / ' . $equipment->getBrandt()  . ' / ' . $equipment->getSerialNumber();
                },
                'attr'              => [
                    'class'         => 'uk-select select-equipments',
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
