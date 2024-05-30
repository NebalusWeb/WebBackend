<?php

namespace Nebalus\Webapi\Middleware;

use InvalidArgumentException;
use Nebalus\Webapi\Exception\ApiException;
use Nebalus\Webapi\Option\EnvData;
use Nebalus\Webapi\ValueObject\AccessLevel;
use Override;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use ReallySimpleJWT\Exception\BuildException;
use ReallySimpleJWT\Token;
use Slim\Middleware\RoutingMiddleware;
use Slim\MiddlewareDispatcher;

class AuthMiddleware implements MiddlewareInterface
{
    private EnvData $env;

    public function __construct(EnvData $env)
    {
        $this->env = $env;
    }

    /**
     * @throws ApiException
     */
    #[Override] public function process(Request $request, RequestHandler $handler): Response
    {
        if (!$request->hasHeader("Authorization")) {
            throw new ApiException("The 'Authorization' header is not provided", 401);
        }
        $jwt = $request->getHeader("Authorization")[0];
        if (empty($jwt)) {
            throw new ApiException("The 'Authorization' header is empty", 401);
        }

        if (!Token::validate($jwt, $this->env->getJwtSecret())) {
            throw new ApiException("The JWT is not valid", 401);
        }

        if (!Token::validateExpiration($jwt)) {
            throw new ApiException("The JWT has expired", 401);
        }

        $payload = Token::getPayload($jwt);

        if (empty($payload["is_admin"]) === false) {
            $request = $request->withAttribute("is_admin", $payload["is_admin"]);
        }

        return $handler->handle($request);
    }
}
