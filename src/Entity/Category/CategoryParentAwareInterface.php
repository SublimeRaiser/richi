<?php

namespace App\Entity\Category;

interface CategoryParentAwareInterface
{
    /**
     * Returns parent category entity.
     *
     * @return BaseCategory|null
     */
    public function getParent(): ?BaseCategory;

    /**
     * Sets parent category entity.
     *
     * @param BaseCategory|null $parent
     *
     * @return BaseCategory
     */
    public function setParent(?BaseCategory $parent): BaseCategory;
}
