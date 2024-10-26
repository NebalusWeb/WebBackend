<?php

declare(strict_types=1);

namespace Nebalus\Webapi\Api\Validator;

abstract class AbstractValidator implements ValidatorInterface
{
    protected string $errorMessage;

    public function __construct()
    {
        $this->errorMessage = '';
    }

    public function getErrorMessage(): string
    {
        return $this->errorMessage;
    }
}
