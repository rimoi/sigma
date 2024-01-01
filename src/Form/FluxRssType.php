<?php

namespace App\Form;

use App\Entity\FluxRss;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FluxRssType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Titre',
                'attr' => [
                    'placeholder' => 'Titre ( Ex: Youtube )'
                ]
            ])
            ->add('link', TextType::class, [
                'label' => 'Lien',
                'attr' => [
                    'placeholder' => 'Lien ( Ex: https://www.youtube.com/watch?v=BPYOIy1EfMA )'
                ]
            ])
            ->add('classFontAwesome', TextType::class, [
                'label' => 'Classe Font Awesome',
                'attr' => [
                    'placeholder' => 'Classe de la font awesome ( Ex: fab fa-twitter )'
                ],
                'help' => 'Pour voir la liste complète des classes disponibles, cliquez ici : https://fontawesome.com/search?o=r&m=free'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => FluxRss::class,
        ]);
    }
}
