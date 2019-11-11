<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;


class User1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('username')
            ->add('email')
            ->add('password')
            ->add('nom')
            ->add('prenom')
            ->add('dateNaissance')
            ->add('telephone')
            ->add('ville')
            ->add('codePostale')
            ->add('adresse')
            ->add('civilite')
            ->add('avatarImage', FileType::class, ['required'=> false,'label'=> 'Entrer votre image' ])
            ->add('annonce')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
