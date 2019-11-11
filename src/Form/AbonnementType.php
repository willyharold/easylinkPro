<?php

namespace App\Form;

use App\Entity\Abonnement;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class AbonnementType extends AbstractType
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
            ->add('transaction')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Abonnement::class,
        ]);
    }
}
