<?php

namespace App\Form\Operation;

use App\Entity\Account;
use App\Entity\Category\CategoryIncome;
use App\Entity\Operation\OperationIncome;
use App\Repository\AccountRepository;
use App\Repository\Category\CategoryIncomeRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\User\UserInterface;

class OperationIncomeType extends BaseOperationCashFlowType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        parent::buildForm($builder, $options);

        /** @var UserInterface $user */
        $user         = $this->security->getUser();
        /** @var AccountRepository $accountRepo */
        $accountRepo  = $this->em->getRepository(Account::class);
        /** @var CategoryIncomeRepository $categoryRepo */
        $categoryRepo = $this->em->getRepository(CategoryIncome::class);

        $builder
            ->add('target', EntityType::class, [
                'class'       => Account::class,
                'choices'     => $accountRepo->findNotArchived($user),
            ])
            ->add('category', EntityType::class, [
                'class'       => CategoryIncome::class,
                'choices'     => $categoryRepo->findByUser($user),
                'empty_data'  => null,
                'placeholder' => '---',
                'required'    => true,
            ])
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => OperationIncome::class,
        ]);
    }
}
