<?php

namespace App\Service;

use App\Enum\OperationTypeEnum;

class OperationNameFormatter
{
    /**
     * Returns a slug for the provided operation type.
     *
     * @param integer $type
     *
     * @return string|null
     *
     * @see OperationTypeEnum
     */
    public function getSlugByType(int $type): ?string
    {
        $slug          = null;
        $operationName = OperationTypeEnum::getName($type);
        if ($operationName) {
            $slug = strtolower(str_replace(' ', '-', $operationName));
        }

        return $slug;
    }

    /**
     * Returns a slug for the provided operation type.
     *
     * @param string $slug
     *
     * @return integer|null
     *
     * @see OperationTypeEnum
     */
    public function getTypeBySlug(string $slug): ?int
    {
        $operationType           = null;
        $availableOperationTypes = OperationTypeEnum::getAvailableTypes();
        foreach ($availableOperationTypes as $type) {
            if ($slug === $this->getSlugByType($type)) {
                $operationType = $type;
                break;
            }
        }

        return $operationType;
    }

    /**
     * Returns operation name for the provided slug.
     *
     * @param string $slug
     *
     * @return string|null
     *
     * @see OperationTypeEnum
     */
    public function getNameBySlug(string $slug): ?string
    {
        $operationName = null;
        $operationType = $this->getTypeBySlug($slug);
        if ($operationType) {
            $operationName = OperationTypeEnum::getName($operationType);
        }

        return $operationName;
    }

    /**
     * Returns a camel case representation for the name of the provided operation type.
     *
     * @param integer $type
     *
     * @return string|null
     *
     * @see OperationTypeEnum
     */
    public function getCamelCaseByType(int $type): ?string
    {
        $operationNameCamelCase = null;
        $operationName          = OperationTypeEnum::getName($type);
        if ($operationName) {
            $operationNameCamelCase = str_replace(' ', '', ucwords($operationName));
        }

        return $operationNameCamelCase;
    }
}
