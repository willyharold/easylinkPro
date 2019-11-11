<?php

namespace App\Form;

use App\Entity\ArticleBlog;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ArticleBlogType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre')
            ->add('description')
            ->add('etat', ChoiceType::class, [
                'choices' => [
                    'active' => true,
                    'inactive' => false
                ]
            ])
            ->add('datePub')
            ->add('avatarImage', FileType::class, ['required'=> false,'label'=> 'Entrer votre image' ])
            ->add('categorieBlog')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ArticleBlog::class,
        ]);
    }
}
