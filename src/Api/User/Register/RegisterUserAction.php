<?php

namespace Nebalus\Webapi\Api\User\Register;

use Nebalus\Webapi\Api\AbstractAction;
use Nebalus\Webapi\Exception\ApiException;
use Slim\Http\Response as Response;
use Slim\Http\ServerRequest as Request;

class RegisterUserAction extends AbstractAction
{
    public function __construct(
        private readonly RegisterUserValidator $validator,
        private readonly RegisterUserService $service,
    ) {
    }

    /**
     * @throws ApiException
     */
    protected function execute(Request $request, Response $response, array $pathArgs): Response
    {
        $this->validator->validate($request, $pathArgs);

        $result = $this->service->execute($this->validator);

        return $response->withJson($result->getPayload(), $result->getStatusCode());
    }
}
