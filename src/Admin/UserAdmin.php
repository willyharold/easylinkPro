<?php

declare(strict_types=1);

namespace App\Admin;

use Sonata\AdminBundle\Admin\AbstractAdmin;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Form\Type\Filter\DateType;
use Sonata\AdminBundle\Show\ShowMapper;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TelType;

final class UserAdmin extends AbstractAdmin
{

    protected function configureDatagridFilters(DatagridMapper $datagridMapper): void
    {
        $datagridMapper
            ->add('username')
            ->add('email')
            ->add('enabled')
            ->add('password')
            ->add('lastLogin')
            ->add('roles')
            ->add('id')
            ->add('nom')
            ->add('prenom')
            ->add('dateNaissance')
            ->add('telephone')
            ->add('dateEnreg')
            ->add('ville')
            ->add('codePostale')
            ->add('adresse')
            ->add('civilite')
            ;
    }

    protected function configureListFields(ListMapper $listMapper): void
    {
        $listMapper
            ->add('username')
            ->add('email')
            ->add('enabled')
            ->add('password')
            ->add('roles')
            ->add('id')
            ->add('nom')
            ->add('prenom')
            ->add('dateNaissance')
            ->add('telephone')
            ->add('dateEnreg')
            ->add('ville')
            ->add('codePostale')
            ->add('adresse')
            ->add('civilite')
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
            ->tab('Général')
                ->with('Information personnelle')
                    ->add('nom')
                    ->add('prenom')
                    ->add('dateNaissance')
                    ->add('telephone',TelType::class)
                    ->add('ville')
                    ->add('codePostale')
                    ->add('adresse')
                    ->add('civilite',ChoiceType::class, [
                            'choices' => [
                                'HOMME' => 'HOMME',
                                'FEMME' => 'FEMME',
                            ],
                            'multiple'=> false,
                            'expanded'=> false,
                        ])
                ->end()
                ->with('Information du compte')
                    ->add('username')
                    ->add('email',EmailType::class)
                    ->add('plainPassword',PasswordType::class, ["label"=>"Mot de passe"])
                    ->add('roles', ChoiceType::class, [
                        'choices' => [
                            'CLIENT' => 'ROLE_CLIENT',
                            'ARTISAN' => 'ROLE_ARTISAN',
                            'ADMINISTRATEUR' => 'ROLE_SUPER_ADMIN',
                        ],
                        'multiple'=> true,
                        'expanded'=> false,
                    ])
                    ->add('enabled')
                ->end()
            ->end()

        ;
    }

    protected function configureShowFields(ShowMapper $showMapper): void
    {
        $showMapper
            ->add('username')
            ->add('usernameCanonical')
            ->add('email')
            ->add('emailCanonical')
            ->add('enabled')
            ->add('salt')
            ->add('password')
            ->add('lastLogin')
            ->add('confirmationToken')
            ->add('passwordRequestedAt')
            ->add('roles')
            ->add('id')
            ->add('nom')
            ->add('prenom')
            ->add('dateNaissance')
            ->add('telephone')
            ->add('dateEnreg')
            ->add('ville')
            ->add('codePostale')
            ->add('adresse')
            ->add('civilite')
            ;
    }
}
