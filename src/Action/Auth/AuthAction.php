<?php

declare(strict_types=1);

namespace Nebalus\Webapi\Action\Auth;

use JsonException;
use Nebalus\Webapi\Service\Auth\UserAuthService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class AuthAction
{
    private UserAuthService $userAuthService;

    public function __construct(UserAuthService $userAuthService)
    {
        $this->userAuthService = $userAuthService;
    }

    /**
     * @throws JsonException
     */
    public function action(Request $request, Response $response, array $args): Response
    {
        $bodyParams = $request->getParsedBody() ?? [];
        $apiResponse = $this->userAuthService->execute($bodyParams);

        $response->getBody()->write($apiResponse->getPayloadAsJson());
        return $response->withStatus($apiResponse->getStatusCode());
    }
}
