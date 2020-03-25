<?php

namespace App\Form\Operation;

use App\Entity\Account;
use App\Entity\Fund;
use App\Entity\Tag;
use App\Form\DataTransformer\KopecksToRublesTransformer;
use App\Repository\AccountRepository;
use App\Repository\FundRepository;
use App\Repository\TagRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;

abstract class BaseOperationCashFlowType extends BaseOperationType
{
    /** @var Security */
    protected $security;

    /** @var EntityManagerInterface */
    protected $em;

    /**
     * BaseOperationCashFlowType constructor.
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
        parent::__construct($transformer);
        $this->security = $security;
        $this->em       = $em;
    }

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
        /** @var TagRepository $tagRepo */
        $tagRepo     = $this->em->getRepository(Tag::class);
        /** @var FundRepository $fundRepo */
        $fundRepo    = $this->em->getRepository(Fund::class);

        $builder
            ->add('account', EntityType::class, [
                'class'       => Account::class,
                'choices'     => $accountRepo->findNotArchived($user),
            ])
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
