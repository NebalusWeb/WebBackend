<?php

declare(strict_types=1);

namespace Nebalus\Webapi\ValueObject\ApiResponse;

use InvalidArgumentException;
use JsonException;
use Override;

class ApiSuccessResponse extends AbstractApiResponse
{
    public static function from(array $payload, int $statusCode): self
    {
        return self::fromPayload($payload, $statusCode, true);
    }
}
