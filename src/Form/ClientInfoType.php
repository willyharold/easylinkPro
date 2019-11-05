<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClientInfoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom',null,["attr"=>["placeholder"=>"Nom"]])
            ->add('prenom',null,["attr"=>["placeholder"=>"Prénom"]])
            ->add('telephone',null,["attr"=>["placeholder"=>"Téléphone"]])
            ->add('codePostale',null,["attr"=>["placeholder"=>"Code postale"]])
            ->add('adresse',null,["attr"=>["placeholder"=>"Adresse"]])
            ->add('civilite',ChoiceType::class, [
                'choices' => [
                    'Monsieur' => 'Monsieur',
                    'Madame' => 'Madame',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
