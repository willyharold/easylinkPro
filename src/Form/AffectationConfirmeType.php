<?php

namespace App\Form;

use App\Entity\AffectationConfirme;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

use App\Repository\AnnonceRepository;
use App\Repository\EstimationRepository;

class AffectationConfirmeType extends AbstractType
{
    private $annonce;
    private $estimation;

    public function __construct(AnnonceRepository $AnnonceRepository,EstimationRepository $EstimationRepository)
    {
        $this->annonce=$AnnonceRepository->findByValider(true);
        $this->estimation=$EstimationRepository->findByValider(true);
    }
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('etat', ChoiceType::class, [
            'choices' => [
                'active' => true,
                'inactive' => false
            ]
        ])
        ->add('annonce', null, [
            'choices' => $this->annonce,
        ])
            ->add('artisan')
            ->add('artisanConfirme')
            ->add('estimation', null, [
                'choices' => $this->estimation,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => AffectationConfirme::class,
        ]);
    }
}
