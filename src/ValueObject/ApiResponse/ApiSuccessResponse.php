<?php

namespace Nebalus\Webapi\ValueObject\ApiResponse;

use InvalidArgumentException;
use JsonException;
use Override;

class ApiSuccessResponse implements ApiResponseInterface
{

    private string $json;
    private int $statusCode;
    private function __construct(string $json, int $statusCode)
    {
        $this->json = $json;
        $this->statusCode = $statusCode;
    }

    /**
     * @throws JsonException
     */
    public static function from(array $payload, int $statusCode): ApiSuccessResponse
    {
        if ($statusCode < 100 || $statusCode > 599) {
            throw new InvalidArgumentException("The code '$statusCode' is not a valid http status code!", 500);
        }

        $responseArray = [
            "success" => true,
            "payload" => $payload
        ];

        try {
            $json = json_encode($responseArray, JSON_THROW_ON_ERROR);
        } catch (JsonException) {
            throw new JsonException('Array cannot be encoded in JSON!', 500);
        }

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
