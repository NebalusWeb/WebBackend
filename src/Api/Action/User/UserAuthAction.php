<?php

declare(strict_types=1);

namespace Nebalus\Webapi\Api\Action\User;

use Nebalus\Webapi\Api\Action\ApiAction;
use Nebalus\Webapi\Api\Service\User\UserAuthService;
use Nebalus\Webapi\Exception\ApiException;
use ReallySimpleJWT\Exception\BuildException;
use Slim\Http\Response as Response;
use Slim\Http\ServerRequest as Request;

class UserAuthAction extends ApiAction
{
    public function __construct(
        private readonly UserAuthService $userAuthService
    ) {
    }

    /**
     * @throws ApiException|BuildException
     */
    protected function execute(Request $request, Response $response, array $args): Response
    {
        $bodyParams = $request->getParsedBody() ?? [];
        $result = $this->userAuthService->execute($bodyParams);

        return $response->withJson($result->getPayload(), $result->getStatusCode());
    }
}
