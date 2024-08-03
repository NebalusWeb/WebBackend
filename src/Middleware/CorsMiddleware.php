<?php

declare(strict_types=1);

namespace Nebalus\Webapi\Middleware;

use Nebalus\Webapi\Option\EnvData;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\App;

class CorsMiddleware implements MiddlewareInterface
{
    private App $app;
    private EnvData $env;

    public function __construct(
        App $app,
        EnvData $env
    ) {
        $this->app = $app;
        $this->env = $env;
    }

    public function process(Request $request, RequestHandler $handler): Response
    {
        if ($request->getMethod() === 'OPTIONS') {
            $response = $this->app->getResponseFactory()->createResponse();
        } else {
            $response = $handler->handle($request);
        }

        return $response
            ->withHeader('Access-Control-Allow-Origin', $this->env->getAccessControlAllowOrigin())
            ->withHeader('Access-Control-Allow-Methods', 'Authorization')
            ->withHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, PATCH, DELETE, OPTIONS');
    }
}
