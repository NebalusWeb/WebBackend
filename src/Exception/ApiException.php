<?php

namespace Nebalus\Webapi\Exception;

use Exception;

abstract class ApiException extends Exception
{
    public function __construct(string $message = null, int $code = 500, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
