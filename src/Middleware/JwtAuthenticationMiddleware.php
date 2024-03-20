<?php

namespace Nebalus\Webapi\Middleware;

use InvalidArgumentException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use ReallySimpleJWT\Token;

class JwtAuthenticationMiddleware
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

        if (!Token::validate($token, getenv("JWT_SECRET"))) {
            var_dump(Token::validateExpiration($token));
            $newtoken = Token::create(1, getenv("JWT_SECRET"), time() + 15, 'localhost');
            throw new InvalidArgumentException($newtoken, 401);
        }

        return $handler->handle($request);
    }
}
