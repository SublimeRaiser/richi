<?php

namespace App\Entity\Obligation;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DebtRepository")
 */
class Debt extends BaseObligation
{
}
