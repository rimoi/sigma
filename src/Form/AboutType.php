<?php

namespace App\Form;

use App\Entity\About;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AboutType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre',
                'attr' => [
                    'placeholder' => "Titre de la page ( Ex: A propos )"
                ]
            ])
            ->add('year', IntegerType::class, [
                'label' => 'Année',
                'attr' => [
                    'placeholder' => "Combien d’années d’expérience ?"
                ]
            ])
            ->add('description', CKEditorType::class, [
                'label' => 'Description',
                'required' => 'false',
                'config' => array(
                    'uiColor' => '#ffffff',
                    'editorplaceholder' => 'Description de la page...',
                    'defaultLanguage' => 'fr',
                    //...
                ),
            ])
            ->add('backgroundImage', FileType::class, [
                'label' => 'Image de fond (Idéalement : 1920 × 1080 px)',
                'required' => false,
                'mapped' => false
            ])

            ->add('firstFile', FileType::class, [
                'label' => 'Premier image (Idéalement : 1920 × 1080 px)',
                'required' => false,
                'mapped' => false
            ])
            ->add('secondFile', FileType::class, [
                'label' => 'Deuxième Image (Idéalement : 1920 × 1080 px)',
                'required' => false,
                'mapped' => false
            ])


        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => About::class,
        ]);
    }
}
