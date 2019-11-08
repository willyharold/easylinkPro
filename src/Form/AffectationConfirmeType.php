<?php

namespace App\Form;

use App\Entity\AffectationConfirme;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AffectationConfirmeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('etat')
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
