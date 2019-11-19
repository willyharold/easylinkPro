<?php

namespace App\Form;

use App\Entity\Artisan;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;


class Artisan1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('dateCreateAt')
            ->add('fiscale')
            ->add('siren')
            ->add('adresse')
            ->add('codePostal')
            ->add('telephone')
            ->add('telephone2')
            ->add('sousSpecialite')
            ->add('avatarImage', FileType::class, ['required'=> false,'label'=> 'Entrer votre image de profil' ])
            ->add('user')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Artisan::class,
        ]);
    }
}
