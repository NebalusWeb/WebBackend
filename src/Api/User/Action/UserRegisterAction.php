<?php

namespace Nebalus\Webapi\Api\User\Action;

use Nebalus\Webapi\Api\AbstractAction;
use Nebalus\Webapi\Api\User\Service\UserRegisterService;
use Nebalus\Webapi\Api\User\Validator\UserRegisterValidator;
use Nebalus\Webapi\Exception\ApiException;
use Slim\Http\Response as Response;
use Slim\Http\ServerRequest as Request;

class UserRegisterAction extends AbstractAction
{
    public function __construct(
        private readonly UserRegisterValidator $validator,
        private readonly UserRegisterService $service,
    ) {
    }

    /**
     * @throws ApiException
     */
    protected function execute(Request $request, Response $response, array $args): Response
    {
        $this->validator->validate($request);
        $result = $this->service->execute($this->validator);
        return $response->withJson($result->getPayload(), $result->getStatusCode());
    }
}
