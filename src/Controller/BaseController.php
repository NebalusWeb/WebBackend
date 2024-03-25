<?php

namespace Nebalus\Webapi\Controller;

use Nebalus\Webapi\ValueObject\JsonResponse;
use Psr\Http\Message\ResponseInterface as Response;

class BaseController
{
    protected JsonResponse $jsonResponse;
    public function __construct(JsonResponse $jsonResponse)
    {
        $this->jsonResponse = $jsonResponse;
    }

    protected function failedAction(Response $response, string $errorMessage, int $statusCode = 400): Response
    {
        // Configures the JsonResponse
        $this->jsonResponse->setStatus(-1);
        $this->jsonResponse->setErrorMessage($errorMessage);

        // Formats the JsonResponse in a JSON format
        $json = $this->jsonResponse->format();

        // Writes JSON to body
        $response->getBody()->write($json);

        return $response->withStatus($statusCode);
    }
}
