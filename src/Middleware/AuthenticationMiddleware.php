<?php

namespace Nebalus\Webapi\Middleware;

use InvalidArgumentException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;

class AuthenticationMiddleware
{
    public function __invoke(Request $request, RequestHandler $handler): Response
    {
        if (!$request->hasHeader("token")) {
            throw new InvalidArgumentException("No authentication header 'token' provided.", 401);
        }

        $token = $request->getHeader("token")[0];

        if (empty($token)) {
            throw new InvalidArgumentException("The 'token' header is empty.", 401);
        }

        if ($token != "admin") {
            throw new InvalidArgumentException("Unauthorized, the requested token is invalid or expired.", 401);
        }

        return $handler->handle($request);
    }
}
