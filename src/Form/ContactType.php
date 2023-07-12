<?php

namespace App\Form;

use App\Constant\UserConstant;
use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Regex;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'required' => false,
                'label' => 'Nom :',
                'attr' => [
                    'placeholder' => 'Jean Dupond'
                ],
            ])
            ->add('email', EmailType::class, [
                'label' => 'E-mail (*) :',
                'attr' => [
                    'placeholder' => 'jean.dupond@gmail.com'
                ]
            ])
            ->add('phone', TelType::class, [
                'label' => "Numéro de téléphone :",
                'required' => false,
                'attr' => [
                    'placeholder' => '22 37 56 00'
                ],
            ])
            ->add('content', TextareaType::class, [
                'label' => 'Message (*) :',
                'attr' => [
                    'placeholder' => 'Dites-nous tout...',
                    'rows' => 5
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}
