<?php


namespace App\Service;

use App\Entity\Operation\BaseOperation;
use App\Repository\OperationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * Class OperationList
 * @package App\Service
 */
class OperationList
{
    /** @var EntityManagerInterface */
    private $em;

    /** @var OperationRepository */
    private $operationRepo;

    /**
     * OperationList constructor.
     *
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em            = $em;
        $this->operationRepo = $em->getRepository(BaseOperation::class);
    }

    /**
     * Return operation list for the user grouped by days.
     *
     * @param UserInterface $user
     *
     * @return BaseOperation[]
     */
    public function getGroupedByDays(UserInterface $user): array
    {
        $groupedOperations = [];

        $allOperations = $this->operationRepo->findByUser($user, 'DESC');
        foreach ($allOperations as $operation) {
            $operationDate                       = $operation->getDate()->getTimestamp();
            $groupedOperations[$operationDate][] = $operation;
        }

        return $groupedOperations;
    }
}
