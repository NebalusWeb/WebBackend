<?php

declare(strict_types=1);

namespace Nebalus\Webapi\Value\ApiResponse;

use InvalidArgumentException;
use JsonException;
use Nebalus\Webapi\Value\ApiResponse\ApiResponseInterface;

readonly class ApiResponse implements ApiResponseInterface
{
    private function __construct(
        private array $payload,
        private int $statusCode,
        private bool $success
    ) {
    }

    public static function createError(string $errorMessage, int $statusCode): static
    {
        $payload = ['error_message' => $errorMessage];
        return static::fromPayload($payload, $statusCode, false);
    }

    protected static function fromPayload(array $payload, int $statusCode, bool $success): static
    {
        $payload = array_merge(['success' => $success, 'code' => $statusCode], $payload);

        if ($statusCode < 100 || $statusCode > 599) {
            throw new InvalidArgumentException("Code '$statusCode' is not a valid http status code!", 500);
        }

        return new static($payload, $statusCode, $success);
    }

    public static function createSuccess(array $payload, int $statusCode): static
    {
        return static::fromPayload($payload, $statusCode, true);
    }

    /** @throws JsonException */
    public function getPayloadAsJson(): string
    {
        return json_encode($this->payload, JSON_THROW_ON_ERROR | JSON_NUMERIC_CHECK);
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function isSuccessful(): bool
    {
        return $this->success;
    }
}
