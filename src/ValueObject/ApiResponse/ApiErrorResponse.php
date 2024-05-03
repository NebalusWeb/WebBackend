<?php

namespace Nebalus\Webapi\ValueObject\ApiResponse;

use Override;

class ApiErrorResponse implements ApiResponseInterface
{
    private string $json;
    private int $statusCode;
    private function __construct(string $json, int $statusCode)
    {
        $this->json = $json;
        $this->statusCode = $statusCode;
    }

    public static function from(string $errorMessage = "Undefined Error... please contact an admin!", int $statusCode = 500): self
    {
        $json = '{"success":false,"error":{"code":' . $statusCode . ',"info":"' . $errorMessage . '"}}';

        return new self($json, $statusCode);
    }

    #[Override] public function getMessageAsJson(): string
    {
        return $this->json;
    }

    #[Override] public function getStatusCode(): int
    {
        return $this->statusCode;
    }
}
