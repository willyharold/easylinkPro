<?php

namespace App\Form;

use App\Entity\SousSpecialite;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SousSpecialiteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('desCourte')
            ->add('desLongue')
            ->add('image')
            ->add('specialite')
            ->add('artisans')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SousSpecialite::class,
        ]);
    }
}
