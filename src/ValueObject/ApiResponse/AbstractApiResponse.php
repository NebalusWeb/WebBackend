<?php

declare(strict_types=1);

namespace Nebalus\Webapi\ValueObject\ApiResponse;

use InvalidArgumentException;
use JsonException;

abstract class AbstractApiResponse implements ApiResponseInterface
{
    private array $payload;
    private int $statusCode;
    private bool $successful;

    private function __construct(array $payload, int $statusCode, bool $successful)
    {
        $this->payload = $payload;
        $this->statusCode = $statusCode;
        $this->successful = $successful;
    }

    protected static function fromPayload(array $payload, int $statusCode, bool $successful): static
    {
        if ($statusCode < 100 || $statusCode > 599) {
            throw new InvalidArgumentException("Code '$statusCode' is not a valid http status code!", 500);
        }

        $payload = array_merge(['successful' => $successful], $payload);

        return new static($payload, $statusCode, $successful);
    }

    /**
     * @throws JsonException
     */
    public function getMessageAsJson(): string
    {
        return json_encode($this->payload, JSON_THROW_ON_ERROR | JSON_NUMERIC_CHECK);
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function isSuccessful(): bool
    {
        return $this->successful;
    }
}
