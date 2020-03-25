<?php

namespace App\Form\Operation;

use App\Form\DataTransformer\KopecksToRublesTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;

abstract class BaseOperationType extends AbstractType
{
    /** @var KopecksToRublesTransformer */
    protected $transformer;

    /**
     * BaseOperationType constructor.
     *
     * @param KopecksToRublesTransformer $transformer
     */
    public function __construct(KopecksToRublesTransformer $transformer)
    {
        $this->transformer = $transformer;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date', DateType::class)
            ->add('amount', NumberType::class, [
                'scale' => 2,
            ])
            ->add('description')
        ;

        $builder->get('amount')
            ->addModelTransformer($this->transformer);
    }
}
