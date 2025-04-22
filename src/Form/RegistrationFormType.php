<?php
namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\User;

class RegistrationFormType extends AbstractType
{
public function buildForm(FormBuilderInterface $builder, array $options): void
{
$builder
->add('email', EmailType::class, [
'label' => 'Adresse email',
'attr' => ['placeholder' => 'email@example.com'],
])
->add('plainPassword', PasswordType::class, [
'label' => 'Mot de passe',
'mapped' => false,
'attr' => ['autocomplete' => 'new-password', 'placeholder' => 'Choisissez un mot de passe'],
'constraints' => [
new NotBlank(['message' => 'Merci de renseigner un mot de passe']),
new Length(['min' => 6, 'minMessage' => 'Votre mot de passe doit contenir au moins {{ limit }} caractères']),
],
]);
}

public function configureOptions(OptionsResolver $resolver): void
{
$resolver->setDefaults(['data_class' => User::class]);
}
}
