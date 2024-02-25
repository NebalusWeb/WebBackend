<?php

namespace Nebalus\Ownsite\ValueObject;

use Nebalus\Ownsite\Repository\MysqlRepository;

class MysqlRepositoryResponse
{

    private bool $hasError;

    private function __construct(bool $hasError)
    {
        $this->hasError = $hasError;
    }

    public static function from(bool $hasError): self
    {
        return new MysqlRepositoryResponse();
    }
}