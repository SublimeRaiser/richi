<?php

namespace App\Entity\Operation;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Operation\OperationDebtRepository")
 */
class OperationDebt extends BaseOperationObligation
{
}
