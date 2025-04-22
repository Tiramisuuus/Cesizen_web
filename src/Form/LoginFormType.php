<?php
namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LoginFormType extends AbstractType
{
public function buildForm(FormBuilderInterface $builder, array $options): void
{
$builder
->add('email', EmailType::class, [
'label' => 'Adresse email',
'attr' => ['placeholder' => 'email@example.com'],
])
->add('password', PasswordType::class, [
'label' => 'Mot de passe',
'attr' => ['placeholder' => 'Votre mot de passe'],
]);
}
}
