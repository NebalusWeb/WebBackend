<?php

namespace Nebalus\Webapi\ValueObject\ApiResponse;

use Override;

class ApiErrorResponse extends AbstractApiResponse
{
    public static function from(string $errorMessage, int $statusCode): self
    {
        $payload = ['error_message' => $errorMessage];
        return self::fromPayload($payload, $statusCode, false);
    }
}
