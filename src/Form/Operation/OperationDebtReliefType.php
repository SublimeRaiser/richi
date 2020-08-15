<?php

namespace App\Form\Operation;

use App\Entity\Operation\OperationDebtRelief;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OperationDebtReliefType extends BaseOperationType
{
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => OperationDebtRelief::class,
        ]);
    }
}
