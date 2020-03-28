<?php

namespace App\Form\Operation;

use App\Entity\Operation\OperationRepayment;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OperationRepaymentType extends BaseOperationObligationType
{
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => OperationRepayment::class,
        ]);
    }
}
