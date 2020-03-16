<?php

namespace App\Form\Category;

use App\Entity\Category\IncomeCategory;
use App\Repository\Category\IncomeCategoryRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class IncomeCategoryType extends BaseCategoryType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        /** @var IncomeCategoryRepository $categoryRepo */
        $categoryRepo = $this->em->getRepository(IncomeCategory::class);
        $builder
            ->add('parent', EntityType::class, [
                'class'        => IncomeCategory::class,
                'choices'      => $categoryRepo->findAbleToBeParent($this->user),
                'empty_data'   => null,
                'placeholder'  => '---',
                'required'     => false,
            ])
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => IncomeCategory::class,
        ]);
    }
}
