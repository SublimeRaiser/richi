<?php

namespace App\Form;

use App\Entity\BaseCategory;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;

class CategoryType extends AbstractType
{
    /** @var Security */
    private $security;

    /** @var EntityManagerInterface */
    private $em;

    /**
     * CategoryType constructor.
     *
     * @param Security               $security
     * @param EntityManagerInterface $em
     */
    public function __construct(Security $security, EntityManagerInterface $em)
    {
        $this->security = $security;
        $this->em       = $em;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /** @var UserInterface $user */
        $user          = $this->security->getUser();
        $operationType = $options['operation_type'];

        /** @var CategoryRepository $categoryRepo */
        $categoryRepo = $this->em->getRepository(BaseCategory::class);

        $builder
            ->add('parent', EntityType::class, [
                'class'        => BaseCategory::class,
                'choices'      => $categoryRepo->findAbleToBeParent($user, $operationType),
                'empty_data'   => null,
                'placeholder'  => '---',
                'required'     => false,
            ])
            ->add('name')
            ->add('icon')
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => BaseCategory::class,
        ]);

        $resolver->setRequired('operation_type');
        $resolver->setAllowedTypes('operation_type', 'int');
    }
}
