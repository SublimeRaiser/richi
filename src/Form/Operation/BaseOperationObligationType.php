<?php

namespace App\Form\Operation;

use App\Entity\Account;
use App\Entity\Person;
use App\Repository\AccountRepository;
use App\Repository\PersonRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

abstract class BaseOperationObligationType extends BaseOperationType
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
        /** @var PersonRepository $personRepo */
        $personRepo  = $this->em->getRepository(Person::class);

        $builder
            ->add('account', EntityType::class, [
                'class'       => Account::class,
                'choices'     => $accountRepo->findNotArchived($user),
            ])
            ->add('person', EntityType::class, [
                'class'       => Person::class,
                'choices'     => $personRepo->findByUser($user),
                'empty_data'  => null,
                'placeholder' => '---',
                'required'    => true,
            ])
        ;
    }
}
