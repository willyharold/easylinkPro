<?php

namespace App\Form;

use App\Entity\Annonce;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class Annonce1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('description')
            ->add('adresse')
            ->add('codePostale')
            ->add('etat', ChoiceType::class, [
                'choices' => [
                    'active' => true,
                    'inactive' => false
                ]
            ])
            ->add('sousSpectialite')
            ->add('client')
            ->add('artisan')
            ->add('affectation')
            ->add('affectationConfirme')
            ->add('artisanEtat')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Annonce::class,
        ]);
    }
}
