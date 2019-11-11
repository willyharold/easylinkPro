<?php

namespace App\Form;

use App\Entity\SousSpecialite;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class SousSpecialiteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('desCourte')
            ->add('desLongue')
            ->add('FichierImage', FileType::class, ['required'=> false,'label'=> 'Entrer votre image' ])
            ->add('specialite')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => SousSpecialite::class,
        ]);
    }
}
