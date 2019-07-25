<?php

declare(strict_types=1);

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\Extension\Core\Type\TelType;

final class ArtisanAdmin extends AbstractAdmin
{

    protected function configureDatagridFilters(DatagridMapper $datagridMapper): void
    {
        $datagridMapper
            ->add('id')
            ->add('nom')
            ->add('dateCreateAt')
            ->add('fiscale')
            ->add('siren')
            ->add('adresse')
            ->add('codePostal')
            ->add('telephone')
            ->add('telephone2')
            ;
    }

    protected function configureListFields(ListMapper $listMapper): void
    {
        $listMapper
            ->add('id')
            ->add('nom')
            ->add('fiscale')
            ->add('siren')
            ->add('adresse')
            ->add('codePostal')
            ->add('telephone')
            ->add('dateCreateAt')
            ->add('user')

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
            ->add('nom')
            ->add('fiscale')
            ->add('siren')
            ->add('adresse')
            ->add('codePostal')
            ->add('telephone',TelType::class)
            ->add('telephone2',TelType::class)
            ->add('user')
            ;
    }

    protected function configureShowFields(ShowMapper $showMapper): void
    {
        $showMapper
            ->add('id')
            ->add('nom')
            ->add('fiscale')
            ->add('siren')
            ->add('adresse')
            ->add('codePostal')
            ->add('telephone')
            ->add('telephone2')
            ->add('user')
            ->add('dateCreateAt')

        ;
    }
}
