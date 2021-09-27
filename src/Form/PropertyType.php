<?php

namespace App\Form;

use App\Entity\Property;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PropertyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('surface')
            ->add('content')
            ->add('price')
            ->add('floor')
            ->add('rooms')
            ->add('address')
            ->add('zipcode')
            ->add('city')
            ->add('type')
            ->add('transactionType')
            ->add('groundSize')
            ->add('dateOfConstruction')
            ->add('sell')
            ->add('slug')
            ->add('employee')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Property::class,
        ]);
    }
}
