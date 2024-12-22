<?php

declare(strict_types=1);

namespace Nebalus\Webapi\Slim\Middleware;

use Nebalus\Webapi\Option\EnvData;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\App;

readonly class CorsMiddleware implements MiddlewareInterface
{
    public function __construct(
        private App $app,
        private EnvData $env
    ) {
    }

    public function process(Request $request, RequestHandler $handler): Response
    {
        if ($request->getMethod() === 'OPTIONS') {
            return $this->withCorsHeaders($this->app->getResponseFactory()->createResponse());
        }

        return $this->withCorsHeaders($handler->handle($request));
    }

    private function withCorsHeaders(Response $response): Response
    {
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withHeader('Access-Control-Allow-Origin', $this->env->getAccessControlAllowOrigin())
            ->withHeader('Access-Control-Allow-Methods', 'Authorization')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, PATCH, DELETE, OPTIONS');
    }
}
