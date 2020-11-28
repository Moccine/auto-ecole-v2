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
                'label' => 'app.form.registration.lastName',
                'required' => true,
            ])
            ->add('firstName', null, [
                'label' => 'app.form.registration.firstName',
                'required' => true,
            ])
            ->add('phone', null, [
                'label' => 'app.form.registration.phone',
                'required' => true,
                'attr' => [
                    'type' => 'number',
                ],
            ])
            ->add('company', null, [
                'label' => 'app.form.registration.company',
            ])
            ->add('siret', null, [
                'label' => 'app.form.registration.siret',
            ])
            ->add('type', ChoiceType::class, [
                'label' => false,
                'choices' => Client::$types,
                'expanded' => true,
                'multiple' => false,
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
