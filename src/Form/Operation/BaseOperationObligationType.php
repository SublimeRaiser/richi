<?php

namespace App\Form\Operation;

use App\Entity\Person;
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
        $user       = $this->security->getUser();
        /** @var PersonRepository $personRepo */
        $personRepo = $this->em->getRepository(Person::class);

        $builder
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
