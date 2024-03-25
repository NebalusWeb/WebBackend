<?php

namespace Nebalus\Webapi\Middleware;

use InvalidArgumentException;
use Nebalus\Webapi\Option\EnvData;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use ReallySimpleJWT\Token;
use Slim\Middleware\RoutingMiddleware;
use Slim\MiddlewareDispatcher;

class JwtAuthMiddleware implements MiddlewareInterface
{
    private EnvData $env;

    public function __construct(EnvData $env)
    {
        $this->env = $env;
    }

    #[\Override] public function process(Request $request, RequestHandler $handler): Response
    {
        if (!$request->hasHeader("jwt")) {
            throw new InvalidArgumentException("No authentication header 'jwt' provided.", 401);
        }
        $token = $request->getHeader("jwt")[0];
        if (empty($token)) {
            throw new InvalidArgumentException("The 'jwt' header is empty.", 401);
        }

        if (!Token::validate($token, $this->env->getJwtSecret())) {
            var_dump(Token::validateExpiration($token));
            $newtoken = Token::create(1, $this->env->getJwtSecret(), time() + 15, 'localhost');
            throw new InvalidArgumentException($newtoken, 401);
        }

        return $handler->handle($request);
    }
}
