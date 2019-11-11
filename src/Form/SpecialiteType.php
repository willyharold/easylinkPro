<?php

namespace App\Form;

use App\Entity\Specialite;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class SpecialiteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('desCourte')
            ->add('desLongue')
            ->add('code')
            ->add('fichierImage', FileType::class, ['required'=> false,'label'=> 'Entrer votre image' ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Specialite::class,
        ]);
    }
}
