<?php

namespace App\Repository\Category;

use App\Entity\Category\BaseCategory;
use App\Repository\BaseRepository;
use Symfony\Component\Security\Core\User\UserInterface;

abstract class BaseCategoryRepository extends BaseRepository
{
    /**
     * Returns a category list for the user.
     *
     * @param UserInterface $user
     *
     * @return BaseCategory[]
     */
    public function findByUser(UserInterface $user): array
    {
        $result = $this->createQueryBuilder('c')
            ->andWhere('c.user = :user')
            ->setParameter('user', $user)
            ->orderBy('c.name', 'ASC')
            ->getQuery()
            ->getResult();

        $this->sortAsString($result);

        return $result;
    }

    /**
     * Returns a list of categories that are able to be a parent category for other categories. Categories are related
     * to the specified user.
     *
     * @param UserInterface $user
     *
     * @return BaseCategory[]
     */
    public function findAbleToBeParent(UserInterface $user): array
    {
        return $this->createQueryBuilder('c')
            ->andWhere('c.user = :user')
            ->andWhere('c.parent IS NULL')
            ->setParameter('user', $user)
            ->orderBy('c.name', 'ASC')
            ->getQuery()
            ->getResult();
    }

    /**
     * Returns a category list of the given operation type for specified user.
     *
     * @param UserInterface $user
     * @param integer       $operationType
     *
     * @return BaseCategory[]
     *
     * @see OperationTypeEnum
     */
    public function findByOperationType(UserInterface $user, int $operationType): array
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

        return $result;
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
