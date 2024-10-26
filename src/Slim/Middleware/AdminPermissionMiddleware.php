<?php

namespace Nebalus\Webapi\Slim\Middleware;

use JsonException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\App;

readonly class AdminPermissionMiddleware implements MiddlewareInterface
{
    public function __construct(
        private App $app
    ) {
    }

    public function process(Request $request, RequestHandler $handler): Response
    {
        // TODO: Implement process() method.
    }

    /**
     * @throws JsonException
     */
    private function abort(string $errorMessage, int $code): Response
    {
        $apiResponse = Response::createError($errorMessage, $code);
        $response = $this->app->getResponseFactory()->createResponse();
        $response->getBody()->write($apiResponse->getPayloadAsJson());
        return $response;
    }
}
