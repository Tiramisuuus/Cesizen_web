<?php
namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChangePasswordFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            // Champ mot de passe actuel
            ->add('currentPassword', PasswordType::class, [
                'label'       => 'Mot de passe actuel',
                'mapped'      => false,
                'constraints' => [
                    new NotBlank(['message' => 'Veuillez saisir votre mot de passe actuel']),
                ],
                'attr'        => ['autocomplete' => 'current-password'],
            ])
            // Champ nouveau mot de passe + confirmation
            ->add('newPassword', RepeatedType::class, [
                'type'            => PasswordType::class,
                'mapped'          => false,
                'first_options'   => ['label' => 'Nouveau mot de passe', 'attr'=>['autocomplete'=>'new-password']],
                'second_options'  => ['label' => 'Confirmer le mot de passe'],
                'invalid_message' => 'Les deux mots de passe doivent être identiques',
                'constraints'     => [
                    new NotBlank(['message' => 'Veuillez renseigner un nouveau mot de passe']),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // pas d'objet lié
        ]);
    }
}
