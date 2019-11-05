<?php

declare(strict_types=1);

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;

final class EstimationAdmin extends AbstractAdmin
{

    protected function configureDatagridFilters(DatagridMapper $datagridMapper): void
    {
        $datagridMapper
            ->add('id')
            ->add('dateEn')
            ->add('etat')
            ->add('typeBien')
            ->add('debutTravaux')
            ->add('ville')
            ->add('addresse')
            ->add('description')
            ->add('codepostal')
            ->add('titre')
            ;
    }

    protected function configureListFields(ListMapper $listMapper): void
    {
        $listMapper
            ->add('id')
            ->add('etat')
            ->add('typeBien')
            ->add('debutTravaux')
            ->add('ville')
            ->add('addresse')
            ->add('description')
            ->add('codepostal')
            ->add('titre')
            ->add('client')
            ->add('dateEn')
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
            ->add('etat')
            ->add('typeBien')
            ->add('debutTravaux')
            ->add('ville')
            ->add('addresse')
            ->add('description')
            ->add('codepostal')
            ->add('titre')
            ->add('client')
            ;
    }

    protected function configureShowFields(ShowMapper $showMapper): void
    {
        $showMapper
            ->add('id')
            ->add('dateEn')
            ->add('etat')
            ->add('typeBien')
            ->add('debutTravaux')
            ->add('ville')
            ->add('addresse')
            ->add('description')
            ->add('codepostal')
            ->add('titre')
            ->add('client')
            ;
    }
}
