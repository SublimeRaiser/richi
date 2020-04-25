<?php

namespace App\Repository;

use App\Entity\Identifiable;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * Class BaseRepository
 * @package App\Repository
 */
abstract class BaseRepository extends ServiceEntityRepository
{
    /**
     * Returns an entity from the provided array with the provided ID.
     *
     * @param Identifiable[] $entities
     * @param integer        $id
     *
     * @return Identifiable|null
     */
    protected function findById(array $entities, int $id): ?Identifiable
    {
        $targetEntity = null;

        foreach ($entities as $entity) {
            if ($entity->getId() === $id) {
                $targetEntity = $entity;
            }
        }

        return $targetEntity;
    }
}
