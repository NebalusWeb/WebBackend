<?php

namespace Nebalus\Webapi\Middleware;

use JsonException;
use Nebalus\Webapi\ValueObject\ApiResponse\ApiResponse;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\App;

readonly class AdminPermissionMiddleware
{
    public function __construct(
        private App $app
    ) {
    }

    /**
     * @throws JsonException
     */
    private function abort(string $errorMessage, int $code): Response
    {
        $apiResponse = ApiResponse::createError($errorMessage, $code);
        $response = $this->app->getResponseFactory()->createResponse();
        $response->getBody()->write($apiResponse->getPayloadAsJson());
        return $response;
    }
}
