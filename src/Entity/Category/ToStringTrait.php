<?php

namespace App\Entity\Category;

trait ToStringTrait
{
    /**
     * Returns string representation for the category.
     *
     * @return string
     */
    public function __toString(): string
    {
        $string = $this->name;
        if ($this->parent) {
            $string = $this->parent->getName() . ' / ' . $string;
        }

        return $string;
    }
}
