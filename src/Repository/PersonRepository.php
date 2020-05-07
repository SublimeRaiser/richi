<?php

namespace App\Repository;

use App\Entity\Person;
use App\ValueObject\Collection\PersonCollection;
use Doctrine\Common\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class PersonRepository
 * @package App\Repository
 */
class PersonRepository extends BaseRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Person::class);
    }

    /**
     * Returns a person list for the user.
     *
     * @param UserInterface $user
     *
     * @return PersonCollection
     */
    public function findByUser(UserInterface $user): PersonCollection
    {
        $result = $this->createQueryBuilder('p')
            ->andWhere('p.user = :user')
            ->setParameter('user', $user)
            ->orderBy('p.name', 'ASC')
            ->getQuery()
            ->getResult();

        return new PersonCollection(...$result);
    }
}
