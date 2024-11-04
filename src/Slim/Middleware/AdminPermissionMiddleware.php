<?php

namespace Nebalus\Webapi\Slim\Middleware;

use Nebalus\Webapi\Value\Result\Result;
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
    }

    private function abort(string $errorMessage, int $code): Response
    {
        $result = Result::createError($errorMessage, $code);
        $response = $this->app->getResponseFactory()->createResponse();
        $response->getBody()->write($result->getPayloadAsJson());
        return $response;
    }
}
