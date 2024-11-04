<?php

namespace Nebalus\Webapi\Api\Action\User;

use Nebalus\Webapi\Api\Action\ApiAction;
use Nebalus\Webapi\Api\Service\User\UserAuthService;
use Slim\Http\Response as Response;
use Slim\Http\ServerRequest as Request;

class UserRegisterAction extends ApiAction
{
    public function __construct(
        private readonly UserAuthService $userAuthService
    ) {
    }

    protected function execute(Request $request, Response $response, array $args): Response
    {
        $bodyParams = $request->getParsedBody() ?? [];
        $result = $this->userAuthService->execute($bodyParams);

        return $response->withJson($result->getPayload(), $result->getStatusCode());
    }
}
