<?php

namespace App\Form;

use App\Entity\Affectation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

use App\Repository\AbonnementRepository;
use App\Repository\AnnonceRepository;
use App\Repository\EstimationRepository;

class AffectationType extends AbstractType
{
    private $artisans;
    private $annonce;
    private $estimation;

    public function __construct(AbonnementRepository $AbonnementRepository,AnnonceRepository $AnnonceRepository,EstimationRepository $EstimationRepository)
    {
        $this->artisans=$AbonnementRepository->findArtisan();
        $this->annonce=$AnnonceRepository->findByValider(false);
        $this->estimation=$EstimationRepository->findByValider(false);
    }
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('artisan', null, [
                'choices' => $this->artisans,
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Affectation::class,
        ]);
    }
}
