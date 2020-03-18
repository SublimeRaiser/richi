<?php

namespace App\Entity\Category;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\Category\CategoryExpenseRepository")
 * @ORM\Table(
 *     name="category_expense",
 *     uniqueConstraints={
 *         @ORM\UniqueConstraint(name="category_expense_uq", columns={"user_id", "parent_id", "name"})
 *     }
 * )
 * @UniqueEntity(
 *     fields={"user", "parent", "name"},
 *     errorPath="name",
 *     message="Expense category with the same name already exists."
 * )
 */
class CategoryExpense extends BaseCategory
{
    /**
     * @var CategoryExpense|null
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Category\CategoryExpense")
     */
    protected $parent;

    /**
     * @return CategoryExpense|null
     */
    public function getParent(): ?self
    {
        return $this->parent;
    }

    /**
     * @param CategoryExpense|null $parent
     *
     * @return CategoryExpense
     */
    public function setParent(?CategoryExpense $parent): self
    {
        $this->parent = $parent;

        return $this;
    }
}
