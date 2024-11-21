<?php

namespace Nebalus\Webapi\Exception;

use Exception;
use Nebalus\Webapi\Exception\ApiException;

class ApiDateMalformedStringException extends ApiException
{
    public function __construct(Exception $previous = null)
    {
        parent::__construct("Invalid or malformed date", 500, $previous);
    }
}
