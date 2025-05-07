<?php

namespace App\Form;

use App\Entity\EmotionTracker;
use App\Entity\SecondaryEmotions;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\RangeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EmotionTrackerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Titre (optionnel)',
                'required' => false,
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description (optionnelle)',
                'required' => false,
            ])
            ->add('score', RangeType::class, [
                'label' => 'Intensité ressentie (1 à 10)',
                'attr' => ['min' => 1, 'max' => 10, 'step' => 1],
                'required' => true,
            ])
            ->add('adviceGiven', TextareaType::class, [
                'label' => 'Conseil donné (facultatif)',
                'required' => false,
            ])
            ->add('secondaryEmotions', EntityType::class, [
                'class' => SecondaryEmotions::class,
                'choice_label' => 'name',
                'label' => 'Émotions ressenties',
                'multiple' => true,
                'expanded' => true, // cases à cocher
                'required' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => EmotionTracker::class,
        ]);
    }
}
