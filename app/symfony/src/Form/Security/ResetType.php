<?php

declare(strict_types=1);

namespace App\Form\Security;

use App\Model\UserResetModel;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ResetType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => UserResetModel::class,
        ]);
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'first_options' => [
                    'label' => 'app.form.reset.newPassword',
                ],
                'second_options' => [
                    'label' => 'app.form.reset.confirmPassword',
                ],
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'app.form.reset.submit',
            ])
        ;
    }
}
