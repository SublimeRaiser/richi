<?php

namespace App\Entity\Category;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Category\CategoryIncomeRepository")
 * @ORM\Table(
 *     name="category_income",
 *     uniqueConstraints={
 *         @ORM\UniqueConstraint(name="category_income_uq", columns={"user_id", "parent_id", "name"})
 *     }
 * )
 * @UniqueEntity(
 *     fields={"user", "parent", "name"},
 *     errorPath="name",
 *     message="Income category with the same name already exists."
 * )
 */
class CategoryIncome extends BaseCategory
{
    /**
     * @var CategoryIncome|null
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Category\CategoryIncome")
     */
    protected $parent;
}
