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

    /**
     * @return CategoryIncome|null
     */
    public function getParent(): ?self
    {
        return $this->parent;
    }

    /**
     * @param CategoryIncome|null $parent
     *
     * @return CategoryIncome
     */
    public function setParent(?CategoryIncome $parent): self
    {
        $this->parent = $parent;

        return $this;
    }
}
