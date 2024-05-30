<?php

namespace Nebalus\Webapi\ValueObject\ApiResponse;

use InvalidArgumentException;
use JsonException;

abstract class AbstractApiResponse
{
    private array $payload;
    private int $statusCode;
    private function __construct(array $payload, int $statusCode)
    {
        $this->payload = $payload;
        $this->statusCode = $statusCode;
    }

    protected static function fromPayload(array $payload, int $statusCode, bool $success): static
    {
        $payload = array_merge(['success' => $success], $payload);

        if ($statusCode < 100 || $statusCode > 599) {
            throw new InvalidArgumentException("Code '$statusCode' is not a valid http status code!", 500);
        }

        return new static($payload, $statusCode);
    }

    /** @throws JsonException */
    public function getMessageAsJson(): string
    {
        return json_encode($this->payload, JSON_THROW_ON_ERROR | JSON_NUMERIC_CHECK);
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }
}