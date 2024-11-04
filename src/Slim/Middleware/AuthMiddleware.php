<?php

declare(strict_types=1);

namespace Nebalus\Webapi\Slim\Middleware;

use Nebalus\Webapi\Option\EnvData;
use Nebalus\Webapi\Value\Result\Result;
use Override;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use ReallySimpleJWT\Token;
use Slim\App;

readonly class AuthMiddleware implements MiddlewareInterface
{
    public function __construct(
        private App $app,
        private EnvData $env
    ) {
    }

    #[Override] public function process(Request $request, RequestHandler $handler): Response
    {
        if ($request->hasHeader("Authorization") === false) {
            return $this->abort("The Authorization header is not provided", 401);
        }

        $jwt = $request->getHeader("Authorization")[0];

        if (empty($jwt)) {
            return $this->abort("The 'Authorization' header is empty", 401);
        }

        if (!Token::validate($jwt, $this->env->getJwtSecret())) {
            return $this->abort("The JWT is not valid", 401);
        }

        if (!Token::validateExpiration($jwt)) {
            return $this->abort("The JWT has expired", 401);
        }

        $payload = Token::getPayload($jwt);

        if (empty($payload["is_admin"]) === false) {
            $request = $request->withAttribute("is_admin", $payload["is_admin"]);
        }

        return $handler->handle($request);
    }

    private function abort(string $errorMessage, int $code): Response
    {
        $apiResponse = Result::createError($errorMessage, $code);
        $response = $this->app->getResponseFactory()->createResponse();
        $response->getBody()->write($apiResponse->getPayloadAsJson());
        return $response;
    }
}
