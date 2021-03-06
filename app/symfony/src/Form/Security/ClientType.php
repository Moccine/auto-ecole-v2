<?php

declare(strict_types=1);

namespace App\Form\Security;

use App\Entity\Client;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClientType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Client::class,
        ]);
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('lastName', null, [
                'label' => false,
                'required' => true,
                'attr' => [
                    'placeholder' => 'app.form.registration.lastName'
                ]
            ])
            ->add('firstName', null, [
                'label' =>  false,
                'required' => true,
                'attr' => [
                    'placeholder' => 'app.form.registration.firstName'
                ]
            ])
            ->add('phone', null, [
                'label' => false,
                'required' => true,
                'attr' => [
                    'type' => 'number',
                    'placeholder' => 'app.form.registration.phone'

                ],
            ])
            ->add('company', null, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'app.form.registration.company'
                ]
            ])
            ->add('address', AddressType::class)
           ;

        $builder->addEventListener(FormEvents::POST_SUBMIT, function (FormEvent $event) {
            $data = $event->getData();
            $form = $event->getForm();

            if ($form->getParent()) {
                $data->setUser($form->getParent()->getData());
            }
        });
    }
}
