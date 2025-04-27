<?php
namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RegisterFormType extends AbstractType
{
public function buildForm(FormBuilderInterface $builder, array $options): void
{
    $builder
        ->add('email', EmailType::class, [
            'label' => 'Adresse email',
            'attr' => ['placeholder' => 'email@example.com'],
        ])
        ->add('plainPassword', PasswordType::class, [
            'label' => 'Confirmer le mot de passe',
            'mapped' => false,
            'attr' => ['placeholder' => 'Confirmez votre mot de passe'],
        ])
        ->add('password', PasswordType::class, [
            'label' => 'Mot de passe',
            'attr' => ['placeholder' => 'Votre mot de passe'],
        ])
        ->add('username', TextType::class , [
            'label' => 'Nom d\'utilisateur',
            'attr' => ['placeholder' => 'Votre nom d\'utilisateur'],
        ])
        ->add('terms', CheckboxType::class, [
            'label' => 'J\'accepte les termes et conditions',
            'mapped' => false,
            'required' => true,
        ])
        ->add('submit', SubmitType::class, [
            'label' => 'S\'inscrire',
        ]);

}
}
