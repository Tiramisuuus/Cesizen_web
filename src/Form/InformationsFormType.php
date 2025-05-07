<?php

namespace App\Form;

use App\Entity\InformationsRessources;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InformationsFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Titre',
                'required' => true,
                'attr' => ['placeholder' => 'Nom de la ressource']
            ])
            ->add('description', TextType::class, [
                'label' => 'Résumé',
                'required' => false,
                'attr' => ['placeholder' => 'Courte description']
            ])
            ->add('content', TextareaType::class, [
                'label' => 'Contenu',
                'required' => false,
                'attr' => [
                    'rows' => 6,
                    'placeholder' => 'Texte ou consignes détaillées…'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => InformationsRessources::class,
        ]);
    }
}
