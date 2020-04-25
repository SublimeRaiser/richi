<?php

namespace App\Form\Category;

use App\Entity\Category\CategoryExpense;
use App\Repository\Category\CategoryExpenseRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CategoryExpenseType extends BaseCategoryType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        /** @var CategoryExpenseRepository $categoryRepo */
        $categoryRepo = $this->em->getRepository(CategoryExpense::class);

        $builder
            ->add('parent', EntityType::class, [
                'class'        => CategoryExpense::class,
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
            'data_class' => CategoryExpense::class,
        ]);
    }
}
