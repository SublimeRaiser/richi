<?php

namespace App\Entity\Operation;

use App\Entity\Category;
use App\Entity\Fund;
use App\Entity\Tag;
use Doctrine\ORM\Mapping as ORM;

class IncomeOperation extends BaseOperation
{
    /**
     * @var Category
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Category")
     */
    private $category;

    /**
     * @var Tag
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Tag", inversedBy="operations")
     */
    private $tag;

    /**
     * @var Fund
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Fund", inversedBy="operations")
     */
    private $fund;

    /**
     * @return Category|null
     */
    public function getCategory(): ?Category
    {
        return $this->category;
    }

    /**
     * @param Category|null $category
     *
     * @return IncomeOperation
     */
    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Tag|null
     */
    public function getTag(): ?Tag
    {
        return $this->tag;
    }

    /**
     * @param Tag|null $tag
     *
     * @return IncomeOperation
     */
    public function setTag(?Tag $tag): self
    {
        $this->tag = $tag;

        return $this;
    }

    /**
     * @return Fund|null
     */
    public function getFund(): ?Fund
    {
        return $this->fund;
    }

    /**
     * @param Fund|null $fund
     *
     * @return IncomeOperation
     */
    public function setFund(?Fund $fund): self
    {
        $this->fund = $fund;

        return $this;
    }
}
