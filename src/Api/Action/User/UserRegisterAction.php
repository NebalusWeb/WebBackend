<?php

namespace Nebalus\Webapi\Api\Action\User;

use Nebalus\Webapi\Api\Action\ApiAction;
use Nebalus\Webapi\Api\Service\User\UserRegisterService;
use Nebalus\Webapi\Api\Validator\User\UserRegisterValidator;
use Nebalus\Webapi\Exception\ApiException;
use Slim\Http\Response as Response;
use Slim\Http\ServerRequest as Request;

class UserRegisterAction extends ApiAction
{
    public function __construct(
        private readonly UserRegisterValidator $userRegisterValidator,
        private readonly UserRegisterService $userRegisterService,
    ) {
    }

    /**
     * @throws ApiException
     */
    protected function execute(Request $request, Response $response, array $args): Response
    {
        $this->userRegisterValidator->validate($request);
        $result = $this->userRegisterService->execute($this->userRegisterValidator);
        return $response->withJson($result->getPayload(), $result->getStatusCode());
    }
}
