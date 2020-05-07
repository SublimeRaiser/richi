<?php

namespace App\Repository\Category;

use App\Repository\BaseRepository;
use App\ValueObject\Collection\BaseCategoryCollection;
use Symfony\Component\Security\Core\User\UserInterface;

abstract class BaseCategoryRepository extends BaseRepository
{
    /**
     * Returns a category list for the user.
     *
     * @param UserInterface $user
     *
     * @return BaseCategoryCollection
     */
    public function findByUser(UserInterface $user): BaseCategoryCollection
    {
        $result = $this->createQueryBuilder('c')
            ->andWhere('c.user = :user')
            ->setParameter('user', $user)
            ->orderBy('c.name', 'ASC')
            ->getQuery()
            ->getResult();

        $this->sortAsString($result);

        return new BaseCategoryCollection(...$result);
    }

    /**
     * Returns a list of categories that are able to be a parent category for other categories. Categories are related
     * to the specified user.
     *
     * @param UserInterface $user
     *
     * @return BaseCategoryCollection
     */
    public function findAbleToBeParent(UserInterface $user): BaseCategoryCollection
    {
        $result = $this->createQueryBuilder('c')
            ->andWhere('c.user = :user')
            ->andWhere('c.parent IS NULL')
            ->setParameter('user', $user)
            ->orderBy('c.name', 'ASC')
            ->getQuery()
            ->getResult();

        return new BaseCategoryCollection(...$result);
    }

    /**
     * Returns a category list of the given operation type for specified user.
     *
     * @param UserInterface $user
     * @param integer       $operationType
     *
     * @return BaseCategoryCollection
     *
     * @see OperationTypeEnum
     */
    public function findByOperationType(UserInterface $user, int $operationType): BaseCategoryCollection
    {
        $result = $this->createQueryBuilder('c')
            ->andWhere('c.user = :user')
            ->andWhere('c.operationType = :operationType')
            ->setParameter('user', $user)
            ->setParameter('operationType', $operationType)
            ->orderBy('c.name', 'ASC')
            ->getQuery()
            ->getResult();

        $this->sortAsString($result);

        return new BaseCategoryCollection(...$result);
    }

    /**
     * Sorts given array of categories as a strings. That is necessary as a category may have a parent category. To make
     * this approach working the Category class should implement __toString() method that considers a parent category
     * as well.
     *
     * @param array $result
     *
     * @return boolean
     */
    private function sortAsString(array &$result): bool
    {
        return sort($result, SORT_STRING);
    }
}
