<?php

namespace App\Form;

use App\Entity\Estimation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
class EstimationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('typeBien',ChoiceType::class, [
                'choices' => [
                    'Appartement' => 'Appartement',
                    'Maison' => 'Maison',
                    'Immeuble' => 'Immeuble',
                    'Bureau' => 'Bureau',
                    'Commerce' => 'Commerce',
                    'Local industriels et autres' => 'Local industriels et autres',
                ],
                'label'=> 'Type de bien'
            ])
            ->add('debutTravaux',ChoiceType::class, [
                'choices'=> [
                    'Immediatement'=>'Immediatement',
                    '1-3 mois'=>'1-3 mois',
                    '4-5 mois'=>'4-5 mois',
                    '6 mois ou plus'=>'6 mois ou plus',
                ],
                'label'=> 'Début des travaux'
            ])
            ->add('ville')
            ->add('description')
            ->add('fichierImage', FileType::class, ['required'=> false,'label'=> 'Entrer votre image' ])
            ->add('codepostal')
            ->add('specialite',null,["label"=>"Selectionnez le type de travaux à réaliser "])
            ->add('sousSpecialite',null,["label"=>"Précisez les Travaux à réaliser "])
            ->add('titre',ChoiceType::class, [
                'choices' => [
                    'Installation' => 'Installation',
                    'Remplacement' => 'Remplacement',
                    'Réparation' => 'Réparation',
                    'Entretien ou Maintenance' => 'Entretien ou Maintenance',
                ],
                'label'=> 'Titre'
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Estimation::class,
        ]);
    }
}
