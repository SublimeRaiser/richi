<?php

namespace App\Form\Operation;

use App\Entity\Fund;
use App\Entity\Tag;
use App\Repository\FundRepository;
use App\Repository\TagRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

abstract class BaseOperationCashFlowType extends BaseOperationType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        parent::buildForm($builder, $options);

        /** @var UserInterface $user */
        $user     = $this->security->getUser();
        /** @var TagRepository $tagRepo */
        $tagRepo  = $this->em->getRepository(Tag::class);
        /** @var FundRepository $fundRepo */
        $fundRepo = $this->em->getRepository(Fund::class);

        $builder
            ->add('tag', EntityType::class, [
                'class'       => Tag::class,
                'choices'     => $tagRepo->findByUser($user),
                'empty_data'  => null,
                'placeholder' => '---',
                'required'    => false,
            ])
            ->add('fund', EntityType::class, [
                'class'       => Fund::class,
                'choices'     => $fundRepo->findByUser($user),
                'empty_data'  => null,
                'placeholder' => '---',
                'required'    => false,
            ])
        ;
    }
}
