<?php

declare(strict_types=1);

namespace App\Form\Security;

use App\Entity\Address;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AddressType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Address::class,
        ]);
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('address', TextType::class, [
                'label' => 'app.form.registration.address',
                'required' => true,
            ])
            ->add('postalCode', TextType::class, [
                'label' => 'app.form.registration.postalCode',
            ])
            ->add('city', TextType::class, [
                'label' => 'app.form.registration.city',
                'required' => true,
            ])
            ->add('country', ChoiceType::class, [
                'label' => 'app.form.registration.country',
                'choices' => array_flip(Address::$countries),
                'required' => true,
            ])
        ;
    }
}
