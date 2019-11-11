<?php

namespace App\Form;

use App\Entity\Transaction;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TransactionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('prix')
            ->add('numero')
            ->add('start')
            ->add('end')
            ->add('status')
            ->add('token')
            ->add('amount')
            ->add('response')
            ->add('coupon')
            ->add('pack')
            ->add('abonnement')
            ->add('artisan')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Transaction::class,
        ]);
    }
}
