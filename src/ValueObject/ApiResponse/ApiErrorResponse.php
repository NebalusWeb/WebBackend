<?php

declare(strict_types=1);

namespace Nebalus\Webapi\ValueObject\ApiResponse;

class ApiErrorResponse extends AbstractApiResponse
{
    public static function fromError(string $errorMessage, int $statusCode): self
    {
        $payload = ['error_message' => $errorMessage];
        return self::fromPayload($payload, $statusCode, false);
    }
}
