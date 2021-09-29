<?php

namespace App\Form;

use App\Entity\Appointment;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class AppointmentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $year = date("Y");
        $builder
            ->add('firstname_customer',TextType::class, [
                "label" => "Votre prénom"
            ])
            ->add('lastName_customer',TextType::class, [
                "label" => "Votre nom"
            ])
            ->add('phone_customer',TextType::class, [
                "label" => "Votre numéro de téléphone"
            ])
            ->add('mail_customer', TextType::class, [
                "label" => "Votre adresse mail"
            ])
            ->add('dateOf',DateTimeType::class, [
                "label" => "La date du rendez-vous",
                'hours' => [9,10,11,13,14,15,16,17],
                'with_minutes' => false,
                'date_widget' => "choice",
                'time_widget' => "choice",
                'years' => [date("Y"), date("Y")+1],
                'invalid_message' => "La plage horaire du rendez-vous n'est pas valide, merci de vérifier que vous prenez rendez-vous sur les horaires d'ouverture de l'agence."
            ])
            ->add('message',TextareaType::class, [
                "label" => "Vous souhaitez en profiter pour nous transmettre un message ?"
            ])
            ->add('submit', SubmitType::class)
            ;

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Appointment::class,
        ]);
    }
}
