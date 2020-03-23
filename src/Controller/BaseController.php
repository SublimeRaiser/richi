<?php

namespace App\Controller;

use App\Enum\OperationTypeEnum;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class BaseController extends AbstractController
{
    /**
     * Throws the exception if provided operation name is not supported.
     *
     * @param string $operationName
     *
     * @return void
     */
    protected function checkOperationName(string $operationName): void
    {
        if (!OperationTypeEnum::isTypeExists($operationName)) {
            throw new BadRequestHttpException('Unsupported operation name provided.');
        }
    }

}
