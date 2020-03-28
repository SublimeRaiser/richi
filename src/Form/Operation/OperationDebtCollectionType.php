<?php

namespace App\Form\Operation;

use App\Entity\Operation\OperationDebtCollection;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OperationDebtCollectionType extends BaseOperationObligationType
{
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => OperationDebtCollection::class,
        ]);
    }
}
