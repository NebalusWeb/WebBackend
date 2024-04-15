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
    #[\Override] public function process(Request $request, RequestHandler $handler): Response
    {
        if (!$request->hasHeader("Authorization")) {
            throw new ApiException("No authentication header 'Authorization' provided", 401);
        }
        $jwt = $request->getHeader("Authorization")[0];
        if (empty($jwt)) {
            throw new ApiException("The 'Authorization' header is empty", 401);
        }
        if (!Token::validate($jwt, $this->env->getJwtSecret())) {
            throw new ApiException("The jwt is not valid", 401);
        }
        $newJwt = Token::builder($this->env->getJwtSecret())
            ->setPayloadClaim("user_id", 1)
            ->setPayloadClaim("is_admin", true)
            ->setExpiration(time() + 30)
            ->setIssuer("localhost")
            ->setIssuedAt(time())
            ->build();

        if (!Token::validateExpiration($jwt)) {
            throw new ApiException("The jwt has expired " . $newJwt->getToken(), 401);
        }

        $payload = Token::getPayload($jwt);
        if (empty($payload["is_admin"]) === false) {
            $request = $request->withAttribute("isAdmin", $payload["is_admin"]);
        }

        return $handler->handle($request);
    }
}
//            var_dump(Token::validateExpiration($token));
//            $newtoken = Token::create(1, $this->env->getJwtSecret(), time() + 15, 'localhost');
