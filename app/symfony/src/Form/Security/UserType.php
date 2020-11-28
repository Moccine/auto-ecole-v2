<?php

declare(strict_types=1);

namespace App\Form\Security;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'app.form.registration.userName'
                ]
            ])
            ->add('plainPassword', RepeatedType::class, [
                'label' => 'app.form.registration.plainPassword',
                'type' => PasswordType::class,
                'invalid_message' => 'app.form.registration.passwordNotIdentical',
                'first_options' => [
                    'label' => false,
                    'attr' => [
                        'placeholder' => 'app.form.registration.plainPassword'
                    ]],
                'second_options' => [
                    'label' => false,
                    'attr' => [
                        'placeholder' => 'app.form.registration.secondPassword'
                    ]
                ],
            ])
            ->add('client', ClientType::class)
            ->add('submit', SubmitType::class, [
                'label' => 'app.form.registration.submit',
            ]);
    }

    public function getBlockPrefix(): ?string
    {
        return '';
    }
}
