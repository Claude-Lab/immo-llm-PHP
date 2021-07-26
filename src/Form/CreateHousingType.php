<?php

namespace App\Form;

use App\Entity\Housing;
use App\Entity\Owner;
use App\Entity\User;
use App\Entity\Sort;
use App\Repository\OwnerRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
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

        $owner = $this->ownerRepository->findAll();


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
            ->add('housingLoad', NumberType::class, [
                'label'             => false
            ])
            ->add('floor', IntegerType::class, [
                'label'             => false
            ])
            ->add('attic', CheckboxType::class, [
                'label'             => false,
                'attr' => ['type' => 'checkbox label'],
                'required'          => false
            ])
            ->add('cellar', CheckboxType::class, [
                'label'             => false,
                'attr' => ['type' => 'checkbox label'],
                'required'          => false
            ])
            ->add('pool', CheckboxType::class, [
                'label'             => false,
                'attr' => ['type' => 'checkbox label'],
                'required'          => false
            ])
            ->add('box', CheckboxType::class, [
                'label'             => false,
                'attr' => ['type' => 'checkbox label'],
                'required'          => false
            ])
            ->add('landSurface', NumberType::class, [
                'label'             => false
            ])
            ->add('nbFloor', IntegerType::class, [
                'label'             => false
            ])
            ->add('elevator', CheckboxType::class, [
                'label'             => false,
                'attr' => ['type' => 'checkbox label'],
                'required'          => false
            ])
            ->add('owner', EntityType::class, [
                'class'             => Owner::class,
                'label'             => false,
                'query_builder' => function (OwnerRepository $repository) {
                    return $repository->createQuery('SELECT o.firstname, o.lastname FROM App\Entity\Owner o WHERE o INSTANCE OF App\Entity\User u');
                },
                'choice_label'      => 'firstname' . ' ' . 'lastname'

            ])
            ->add('address', AddressType::class, [
                'label'             => false
            ])
            ->add('sort', EntityType::class, [
                'label'             => false,
                'class'             => Sort::class,
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
