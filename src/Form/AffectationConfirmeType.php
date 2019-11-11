<?php

namespace App\Form;

use App\Entity\AffectationConfirme;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class AffectationConfirmeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('etat', ChoiceType::class, [
            'choices' => [
                'active' => true,
                'inactive' => false
            ]
        ])
            ->add('annonce')
            ->add('artisan')
            ->add('artisanConfirme')
            ->add('estimation')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => AffectationConfirme::class,
        ]);
    }
}
