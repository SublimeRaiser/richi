<?php

namespace App\Form\Operation;

use App\Entity\Operation\OperationDebt;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OperationDebtType extends BaseOperationObligationType
{
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => OperationDebt::class,
        ]);
    }
}
