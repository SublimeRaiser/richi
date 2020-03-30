<?php

namespace App\Entity\Operation;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Operation\OperationDebtCollectionRepository")
 */
class OperationDebtCollection extends BaseOperationObligation
{
}
