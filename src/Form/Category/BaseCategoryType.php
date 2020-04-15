<?php

namespace App\Form\Category;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;

abstract class BaseCategoryType extends AbstractType
{
    /** @var UserInterface */
    protected $user;

    /** @var EntityManagerInterface */
    protected $em;

    /**
     * BaseCategoryType constructor.
     *
     * @param Security               $security
     * @param EntityManagerInterface $em
     */
    public function __construct(Security $security, EntityManagerInterface $em)
    {
        $this->user = $security->getUser();
        $this->em   = $em;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('icon')
        ;
    }
}
