<?php

declare(strict_types=1);

namespace App\Form;

use App\Entity\Submission;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SubmissionType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Submission::class,
        ]);
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstName', TextType::class, [
                'label' => 'app.form.submission.firstName',
            ])
            ->add('lastName', TextType::class, [
                'label' => 'app.form.submission.lastName',
            ])
            ->add('email', EmailType::class, [
                'label' => 'app.form.submission.email',
            ])
            ->add('message', TextareaType::class, [
                'label' => 'app.form.submission.message',
            ])->add('save', SubmitType::class, [
                'label' => 'app.form.submission.save',
            ]);
    }
}
