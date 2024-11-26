<?php

declare(strict_types=1);

namespace Nebalus\Webapi\Api\Action\User;

use Nebalus\Webapi\Api\Action\ApiAction;
use Nebalus\Webapi\Api\Service\User\UserAuthService;
use Nebalus\Webapi\Api\Validator\User\UserAuthValidator;
use Nebalus\Webapi\Exception\ApiException;
use ReallySimpleJWT\Exception\BuildException;
use Slim\Http\Response as Response;
use Slim\Http\ServerRequest as Request;

class UserAuthAction extends ApiAction
{
    public function __construct(
        private readonly UserAuthValidator $validator,
        private readonly UserAuthService $service
    ) {
    }

    /**
     * @throws ApiException|BuildException
     */
    protected function execute(Request $request, Response $response, array $args): Response
    {
        $this->validator->validate($request);
        $result = $this->service->execute($this->validator);
        return $response->withJson($result->getPayload(), $result->getStatusCode());
    }
}
