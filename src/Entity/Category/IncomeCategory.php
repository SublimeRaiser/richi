<?php

namespace App\Entity\Category;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity()
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Table(
 *     name="income_category",
 *     uniqueConstraints={
 *         @ORM\UniqueConstraint(name="income_category_uq", columns={"user_id", "parent_id", "name"})
 *     }
 * )
 * @UniqueEntity(
 *     fields={"user", "parent", "name"},
 *     errorPath="name",
 *     message="Income category with the same name already exists."
 * )
 */
class IncomeCategory extends BaseCategory
{
    use ToStringTrait;

    /**
     * @var IncomeCategory|null
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Category\IncomeCategory")
     */
    protected $parent;

    /**
     * @return IncomeCategory|null
     */
    public function getParent(): ?self
    {
        return $this->parent;
    }

    /**
     * @param IncomeCategory|null $parent
     *
     * @return IncomeCategory
     */
    public function setParent(?IncomeCategory $parent): self
    {
        $this->parent = $parent;

        return $this;
    }
}
