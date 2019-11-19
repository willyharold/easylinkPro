<?php

namespace App\Form;

use App\Entity\Artisan;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;


class ArtisanType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom',TextType::class, ["attr"=>["placeholder"=>"Nom de l'entreprise"]])
            ->add('dateCreateAt',DateType::class,[
                'widget' => 'single_text',
                // prevents rendering it as type="date", to avoid HTML5 date pickers
                'html5' => false,
                'format' => 'dd-MM-yyyy',
                // adds a class that can be selected in JavaScript
                'attr' => ['class' => 'js-datepicker'],
                'placeholder'=> "Date de creation de l'entreprise"
            ])
            ->add('fiscale',TextType::class, ["attr"=>["placeholder"=>"Numero fiscal"]])
            ->add('siren',TextType::class, ["attr"=>["placeholder"=>"Code siren"]])
            ->add('adresse',TextType::class, ["attr"=>["placeholder"=>"Adresse"]])
            ->add('codePostal',TextType::class, ["attr"=>["placeholder"=>"Code postale"]])
            ->add('telephone',TelType::class, ["attr"=>["placeholder"=>"Numero Téléphone"]])
            ->add('telephone2',TelType::class, ["attr"=>["placeholder"=>"Numero Téléphone 2"]])
            ->add('sousSpecialite')
            ->add('avatarImage', FileType::class, ['required'=> false,'label'=> 'Entrer votre image de profil' ])
            
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Artisan::class,
        ]);
    }
}
