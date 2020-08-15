<?php

namespace App\Form\Operation;

use App\Entity\Account;
use App\Entity\Operation\OperationDebt;
use App\Repository\AccountRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\User\UserInterface;

class OperationDebtType extends BaseOperationType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        parent::buildForm($builder, $options);

        /** @var UserInterface $user */
        $user        = $this->security->getUser();
        /** @var AccountRepository $accountRepo */
        $accountRepo = $this->em->getRepository(Account::class);

        $builder
            ->add('target', EntityType::class, [
                'class'   => Account::class,
                'choices' => $accountRepo->findNotArchived($user),
            ])
        ;
    }

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
