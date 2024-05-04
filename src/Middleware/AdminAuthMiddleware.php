<?php

namespace Nebalus\Webapi\Middleware;

use InvalidArgumentException;
use Nebalus\Webapi\Exception\ApiException;
use Nebalus\Webapi\Option\EnvData;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use ReallySimpleJWT\Token;
use Slim\Middleware\RoutingMiddleware;
use Slim\MiddlewareDispatcher;

class AdminAuthMiddleware implements MiddlewareInterface
{
    private EnvData $env;

    public function __construct(EnvData $env)
    {
        $this->env = $env;
    }

    #[\Override] public function process(Request $request, RequestHandler $handler): Response
    {
        return $handler->handle($request);
    }
}
