<?php

namespace App\Form;

use App\Entity\Estimation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Estimation1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('dateEn')
            ->add('etat')
            ->add('typeBien')
            ->add('debutTravaux')
            ->add('ville')
            ->add('addresse')
            ->add('description')
            ->add('codepostal')
            ->add('titre')
            ->add('specialite')
            ->add('sousSpecialite')
            ->add('client')
            ->add('affectation')
            ->add('affectationConfirme')
            ->add('artisanEtat')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Estimation::class,
        ]);
    }
}
