<?php

namespace App\Form;

use App\Entity\SecondaryEmotions;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SecondaryEmotionsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom de l’émotion',
                'required' => true,
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description (facultatif)',
                'required' => false,
            ])
            ->add('score', NumberType::class, [
                'label' => 'Score (ex : 1.5)',
                'required' => false,
                'scale' => 1,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => SecondaryEmotions::class,
        ]);
    }
}
