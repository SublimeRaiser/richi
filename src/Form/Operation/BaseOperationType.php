<?php

namespace App\Form\Operation;

use App\Form\DataTransformer\KopecksToRublesTransformer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Security\Core\Security;

abstract class BaseOperationType extends AbstractType
{
    /** @var KopecksToRublesTransformer */
    protected $transformer;

    /** @var Security */
    protected $security;

    /** @var EntityManagerInterface */
    protected $em;

    /**
     * BaseOperationType constructor.
     *
     * @param Security                   $security
     * @param EntityManagerInterface     $em
     * @param KopecksToRublesTransformer $transformer
     */
    public function __construct(
        KopecksToRublesTransformer $transformer,
        Security $security,
        EntityManagerInterface $em
    ) {
        $this->transformer = $transformer;
        $this->security    = $security;
        $this->em          = $em;
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
