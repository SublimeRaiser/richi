<?php

namespace App\Form\Category;

use App\Entity\Category\ExpenseCategory;
use App\Repository\Category\ExpenseCategoryRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ExpenseCategoryType extends BaseCategoryType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        /** @var ExpenseCategoryRepository $categoryRepo */
        $categoryRepo = $this->em->getRepository(ExpenseCategory::class);
        $builder
            ->add('parent', EntityType::class, [
                'class'        => ExpenseCategory::class,
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
            'data_class' => ExpenseCategory::class,
        ]);
    }
}
