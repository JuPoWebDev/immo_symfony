<?php

namespace App\Form;

use App\Entity\Property;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Validator\Constraints\PositiveOrZero;
use Symfony\Component\Validator\Constraints\GreaterThanOrEqual;

class SearchPropertyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('roomsMin',IntegerType::class,
            [
                'required' => false,
                'constraints' => [
                    new GreaterThanOrEqual(0)
                ]
            ])
            ->add('roomsMax',IntegerType::class,
            [
                'required' => false,
                'constraints' => new PositiveOrZero()
            ])
            ->add('surfaceMin', IntegerType::class,
            [
                'required' => false,
                'constraints' => new PositiveOrZero()
            ])
            ->add('surfaceMax', IntegerType::class,
            [
                'required' => false,
                'constraints' => new PositiveOrZero()
            ])
            ->add('priceMin',IntegerType::class,
            [
                'required' => false,
                'constraints' => new PositiveOrZero()
            ])
            ->add('priceMax',IntegerType::class,
            [
                'required' => false,
                'constraints' => new PositiveOrZero()
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            
        ]);
    }
}
