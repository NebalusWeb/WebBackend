<?php

declare(strict_types=1);

namespace Nebalus\Webapi\Value\Internal\Result;

use InvalidArgumentException;
use Nebalus\Webapi\Exception\ApiException;
use Throwable;

readonly class Result implements ResultInterface
{
    private function __construct(
        private bool $success,
        private ?string $message,
        private int $status,
        private array $payload
    ) {
    }

    protected static function from(bool $success, ?string $message, int $status, array $fields): static
    {
        if ($status < 100 || $status > 599) {
            throw new InvalidArgumentException("Code '$status' is not a valid http status code!", 500);
        }

        $payload = [
            'success' => $success,
            'message' => $message,
            'status' => $status,
            'payload' => $fields,
        ];

        return new static($success, $message, $status, $payload);
    }

    public static function createSuccess(?string $message, int $status = 200, array $fields = []): static
    {
        return static::from(true, $message, $status, $fields);
    }

    public static function createError(?string $message, int $status = 500, array $fields = []): static
    {
        return static::from(false, $message, $status, $fields);
    }

    public static function createFromException(Throwable $throwable, int $status = 500): static
    {
        $isProduction = getenv('APP_ENV') === 'production';

        $throwableAsArray = [];

        if ($isProduction === false && $throwable instanceof ApiException === false) {
            $throwableAsArray['error'] = $throwable->getMessage();
            $throwableAsArray['topic'] = get_class($throwable);
            $throwableAsArray['code'] = $throwable->getCode();
            $throwableAsArray['file'] = $throwable->getFile();
            $throwableAsArray['line'] = $throwable->getLine();
            $throwableAsArray['trace'] = $throwable->getTrace();
            return static::from(false, $throwableAsArray['error'], $status, $throwableAsArray);
        }

        return static::from(false, $throwable->getMessage(), $status, $throwableAsArray);
    }

    public function getPayload(): array
    {
        return $this->payload;
    }

    public function getPayloadAsJson(): string
    {
        return json_encode($this->payload, JSON_PRETTY_PRINT);
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function getStatus(): int
    {
        return $this->status;
    }

    public function isSuccessful(): bool
    {
        return $this->success;
    }
}
