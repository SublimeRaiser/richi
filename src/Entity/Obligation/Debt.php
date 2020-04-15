<?php

namespace App\Entity\Obligation;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Obligation\DebtRepository")
 */
class Debt extends BaseObligation
{
}
