<?php

declare(strict_types=1);

namespace Nebalus\Webapi\Slim\Middleware;

use Nebalus\Webapi\Exception\ApiException;
use Nebalus\Webapi\Option\EnvData;
use Nebalus\Webapi\Repository\UserRepository\MySqlUserRepository;
use Nebalus\Webapi\Value\Result\Result;
use Nebalus\Webapi\Value\User\UserId;
use Override;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use ReallySimpleJWT\Token;
use Slim\App;

readonly class AuthenticationMiddleware implements MiddlewareInterface
{
    public function __construct(
        private App $app,
        private MySqlUserRepository $userRepository,
        private EnvData $env
    ) {
    }

    /**
     * @throws ApiException
     */
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

        if (empty($payload["sub"]) === false && ($user = $this->userRepository->findUserFromId(UserId::from($payload["sub"]))) !== null) {
            $request = $request->withAttribute("user", $user);
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
