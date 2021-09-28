<?php

namespace App\Form;

use App\Entity\User;
use App\Entity\Property;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class PropertyType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class)
            ->add('surface',IntegerType::class)
            ->add('content',TextareaType::class)
            ->add('price',IntegerType::class)
            ->add('floor',IntegerType::class)
            ->add('rooms',IntegerType::class)
            ->add('address',TextType::class)
            ->add('zipcode',TextType::class)
            ->add('city',TextType::class)
            ->add('type',TextType::class)
            ->add('transactionType', ChoiceType::class, [
                'choices'  => [
                    'Vente' => "Vente",
                    'Location' => "Location",
                ]
                ])
            ->add('groundSize',IntegerType::class)
            ->add('dateOfConstruction',IntegerType::class)
            ->add('sell',ChoiceType::class, [
                'choices'  => [
                    'A vendre' => false,
                    'Vendu' => true,
                ]
                ])
            ->add('slug',TextType::class)
            ->add('employee', EntityType::class, [
                'choice_label' => 'lastname',
                'class' => User::class
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Property::class,
        ]);
    }
}
