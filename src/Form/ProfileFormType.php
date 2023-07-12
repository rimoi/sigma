<?php

namespace App\Form;

use App\Constant\GenderConstant;
use App\Constant\UserConstant;
use App\Entity\Category;
use App\Entity\User;
use App\Repository\CategoryRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Regex;

class ProfileFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('telephone', TelType::class, [
                'label' => "Numéro de téléphone",
                'attr' => [
                    'placeholder' => '+222 22 37 56 00'
                ],
                'required' => false
            ])
            ->add('firstname', TextType::class, [
                'label' => 'Prénom :',
                'attr' => [
                    'placeholder' => 'Jean'
                ]
            ])
            ->add('lastname', TextType::class, [
                'label' => 'Nom :',
                'attr' => [
                    'placeholder' => 'Dupond'
                ]
            ])
            ->add('gender', ChoiceType::class, [
                'choices' => GenderConstant::MAP,
                'label' => 'Civilité :',
                'expanded' => true,
                'multiple' => false,
                'attr'=> [
                    'class' => 'd-flex cs-gender-bo'
                ]
            ])
            ->add('adress',TextType::class, [
                'label' => 'Adresse :',
                'required' => false,
                'attr' => [
                    'placeholder' => '23 avenue claude monet, 78120 Rambouillet'
                ]
            ])

        ;


        if ($options['new_user'] ?? false) {
            $builder
                ->add('email', EmailType::class);
        }
        if ($options['edit_user'] ?? false) {
            $user  = $options['data'];
            $roles = $user->getRoles();
                foreach ($roles as $key => $value) {
                    $roles[$key] = UserConstant::asStringInverse($value);
                }

                $builder
                    ->add('enabled', CheckboxType::class, [
                        'label_attr' => ['class' => 'switch-custom'],
                        'label'    => 'Activer ?',
                        'required' => false
                    ])
                    ->add('roles', ChoiceType::class,  [
                        'choices'  => UserConstant::all(),
                        'mapped'   => false,
                        'multiple' => true,
                        'expanded' => true,
                        'data'     => $roles,
                        'required' => false,
                    ])
                    ->add('plainPassword', PasswordType::class, [
                          'label' => 'Mot de passe',
                          'required' => false,
                          'mapped' => false,
                          'attr' => [
                              'placeholder' => '******'
                          ]
                  ]);
            }
    }


    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'new_user' => false,
            'edit_user' => false,
        ]);
    }
}
