<?php

declare(strict_types=1);

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

final class AnnonceAdmin extends AbstractAdmin
{

    protected function configureDatagridFilters(DatagridMapper $datagridMapper): void
    {
        $datagridMapper
            ->add('id')
            ->add('description')
            ->add('adresse')
            ->add('codePostale')
            ->add('dateEnreg')
            ->add('etat')
            ;
    }

    protected function configureListFields(ListMapper $listMapper): void
    {
        $listMapper
            ->add('id')
            ->add('description')
            ->add('adresse')
            ->add('codePostale')
            ->add('etat')
            ->add('client')
            ->add('dateEnreg')

            ->add('_action', null, [
                'actions' => [
                    'show' => [],
                    'edit' => [],
                    'delete' => [],
                ],
            ]);
    }

    protected function configureFormFields(FormMapper $formMapper): void
    {
        $formMapper
            ->add('description',TextareaType::class)
            ->add('adresse')
            ->add('codePostale')
            ->add('client')
            ->add('etat',ChoiceType::class, [
                    'choices' => [
                        'En attente' => 'En attente',
                        'Recherche' => 'Recherche',
                        'Terminer' => 'Terminer',
                    ],
                    'multiple'=> false,
                    'expanded'=> false,
                ])
            ;
    }

    protected function configureShowFields(ShowMapper $showMapper): void
    {
        $showMapper
            ->add('id')
            ->add('description')
            ->add('adresse')
            ->add('codePostale')
            ->add('dateEnreg')
            ->add('etat')
            ;
    }
}
