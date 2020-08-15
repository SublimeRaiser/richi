<?php

namespace App\Form\Operation;

use App\Entity\Operation\OperationLoanRelief;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OperationLoanReliefType extends BaseOperationType
{
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => OperationLoanRelief::class,
        ]);
    }
}
