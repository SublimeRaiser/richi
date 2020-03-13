<?php

namespace App\Entity\Category;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity()
 * @ORM\Table(
 *     name="expense_category",
 *     uniqueConstraints={
 *         @ORM\UniqueConstraint(name="expense_category_uq", columns={"user_id", "parent_id", "name"})
 *     }
 * )
 * @UniqueEntity(
 *     fields={"user", "parent", "name"},
 *     errorPath="name",
 *     message="Expense category with the same name already exists."
 * )
 */
class ExpenseCategory extends BaseCategory
{
    use ToStringTrait;

    /**
     * @var ExpenseCategory|null
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Category\ExpenseCategory")
     */
    protected $parent;

    /**
     * @return ExpenseCategory|null
     */
    public function getParent(): ?self
    {
        return $this->parent;
    }

    /**
     * @param ExpenseCategory|null $parent
     *
     * @return ExpenseCategory
     */
    public function setParent(?ExpenseCategory $parent): self
    {
        $this->parent = $parent;

        return $this;
    }
}
