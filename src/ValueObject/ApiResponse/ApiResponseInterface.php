<?php

namespace Nebalus\Webapi\ValueObject\ApiResponse;

interface ApiResponseInterface
{
    public function getMessageAsJson(): string;
    public function getStatusCode(): int;
}
