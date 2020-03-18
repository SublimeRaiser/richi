<?php

namespace App\Form\Category;

use App\Entity\Category\CategoryIncome;
use App\Repository\Category\CategoryIncomeRepository;
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

        /** @var CategoryIncomeRepository $categoryRepo */
        $categoryRepo = $this->em->getRepository(CategoryIncome::class);
        $builder
            ->add('parent', EntityType::class, [
                'class'        => CategoryIncome::class,
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
            'data_class' => CategoryIncome::class,
        ]);
    }
}
