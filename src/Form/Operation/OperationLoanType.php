<?php

namespace App\Form\Operation;

use App\Entity\Operation\OperationLoan;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OperationLoanType extends BaseOperationObligationType
{
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => OperationLoan::class,
        ]);
    }
}
