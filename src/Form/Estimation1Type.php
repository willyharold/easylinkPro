<?php

namespace App\Form;

use App\Entity\Estimation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class Estimation1Type extends AbstractType
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
            ->add('fichierImage', FileType::class, ['required'=> false,'label'=> 'Entrer votre image' ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Estimation::class,
        ]);
    }
}
