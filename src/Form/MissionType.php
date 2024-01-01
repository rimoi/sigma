<?php

namespace App\Form;

use App\Constant\MissionTypeConstant;
use App\Constant\UserConstant;
use App\Entity\Booking;
use App\Entity\Category;
use App\Entity\Mission;
use App\Entity\Service;
use App\Entity\User;
use App\Repository\CategoryRepository;
use App\Repository\ServiceRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Validator\Constraints\Regex;

class MissionType extends AbstractType
{
    private Security $security;
    private EntityManagerInterface $entityManager;

    public function __construct(Security $security, EntityManagerInterface $entityManager)
    {
        $this->security = $security;
        $this->entityManager = $entityManager;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        /**
         * @var Mission $mission
         */
        
        $mission = $options['data'];

        $started = $mission->getStarted() ? $mission->getStarted()->format('d/m/Y H:i') : '';
        $ended = $mission->getEnded() ? $mission->getEnded()->format('d/m/Y H:i') : '';

        $builder
            // https://symfony.com/doc/current/form/bootstrap5.html
            ->add('title', TextType::class, [
                'label' => 'Nom de la mission: (*)',
                'attr' => ['placeholder' => 'Ex: Constructeur Hôpital'],
            ])
            ->add('type', ChoiceType::class, [
                'label' => 'Type de mission: (*)',
                'choices' => [
                    "Service ( Apparaîtra sur la page d'accueil) " =>  MissionTypeConstant::SERVICE,
                    "Project ( Apparaîtra dans l'onglet Mes projets ) " => MissionTypeConstant::PROJECT,
                ],
                'attr' => [
                    'class' => 'js-select2',
                    'style' => "width: 100%;",
                    'placeholder' => 'Choisir votre Tag'
                ],
            ])
            ->add('content', CKEditorType::class, [
                'required' => 'false',
                'label' => 'false',
                'config' => array(
                    'uiColor' => '#ffffff',
                    'editorplaceholder' => 'Description mission...',
                    'defaultLanguage' => 'fr',
                    //...
                ),
            ])
            ->add('debut', TextType::class, [
                'label' => 'Début mission',
                'required' => false,
                'attr' => [
                    'class' => 'datepicker'
                ],
                "data" => $started,
                'mapped' => false
            ])
            ->add('fin', TextType::class, [
                'label' => 'Fin mission',
                'required' => false,
                'attr' => [
                    'class' => 'datepicker'
                ],
                "data" => $ended,
                'mapped' => false
            ])
            ->add('file', FileType::class, [
                'label' => 'Image principal (Idéalement : 1920 × 1080 px)',
                'required' => true,
                'mapped' => false
            ])
            ->add('published', CheckboxType::class, [
                'required' => false,
                'label' => "Publiée la mission ?",
                'label_attr' => ['class' => 'switch-custom'],
            ])
            ->add('experiences', CollectionType::class, [
                'label' => false,
                'entry_type' => ExperienceType::class,
                'allow_add' => true,
                'prototype' => true,
                // these options are passed to each "email" type
                'entry_options' => [
                    'attr' => ['class' => 'row'],
                ],
                'allow_delete' => true,
                'delete_empty' => true
            ])
            ->add('phone', TelType::class, [
                'label' => "Numéro de téléphone",
                'required' => false,
                'attr' => [
                    'placeholder' => '+22222375600'
                ],
            ])
            ->add('categories', EntityType::class, [
                'class' => Category::class,
                'query_builder' => static function (CategoryRepository $repository) {
                    return $repository->createQueryBuilder('t')
                        ->where('t.archived = :archived')
                        ->setParameter('archived', false)
                        ->addOrderBy('t.title', 'ASC');
                },
                'label' => 'Vous pouvez choisir une/plusieurs tags pour la missions',
                'multiple' => true,
                'by_reference' => false,
                'attr' => [
                    'class' => 'js-select2',
                    'style' => "width: 100%;",
                    'placeholder' => 'Choisir votre Tag'
                ],
            ])
            ->add('address', TextType::class, [
                'attr' => ['placeholder' => '11 Rue chemin, 78120 Rambouillet'],
                'required' => false,
            ])
        ;

    }
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Mission::class,
        ]);
    }
}
