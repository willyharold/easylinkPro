<?php

declare(strict_types=1);

namespace App\Admin;

use FOS\CKEditorBundle\Form\Type\CKEditorType;
use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Show\ShowMapper;
use Sonata\MediaBundle\Form\Type\MediaType;

final class ArticleBlogAdmin extends AbstractAdmin
{

    protected function configureDatagridFilters(DatagridMapper $datagridMapper): void
    {
        $datagridMapper
            ->add('id')
            ->add('titre')
            ->add('description')
            ->add('etat')
            ->add('dateEn')
            ->add('datePub')
            ;
    }

    protected function configureListFields(ListMapper $listMapper): void
    {
        $listMapper
            ->add('id')
            ->add('titre')
            ->add('description',CKEditorType::class,  ['config' => ['uiColor' => '#ffffff']])
            ->add('etat')
            ->add('dateEn')
            ->add('datePub')
            ->add('categorieBlog')
            ->add('avatar')

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
            ->add('titre')
            ->add('description')
            ->add('etat')
            ->add('datePub')
            ->add('categorieBlog')
            ->add('avatar',MediaType::class, [
                'provider' => 'sonata.media.provider.image',
                'context'  => 'blog'])
            ;
    }

    protected function configureShowFields(ShowMapper $showMapper): void
    {
        $showMapper
            ->add('id')
            ->add('titre')
            ->add('description')
            ->add('etat')
            ->add('dateEn')
            ->add('datePub')
            ;
    }
}
