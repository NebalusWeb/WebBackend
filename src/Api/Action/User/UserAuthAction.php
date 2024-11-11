<?php

declare(strict_types=1);

namespace Nebalus\Webapi\Api\Action\User;

use DateMalformedStringException;
use Nebalus\Webapi\Api\Action\ApiAction;
use Nebalus\Webapi\Api\Service\User\UserAuthService;
use Nebalus\Webapi\Exception\ApiDatabaseException;
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
     * @throws DateMalformedStringException
     * @throws BuildException|ApiDatabaseException
     */
    protected function execute(Request $request, Response $response, array $args): Response
    {
        $bodyParams = $request->getParsedBody() ?? [];
        $result = $this->userAuthService->execute($bodyParams);

        return $response->withJson($result->getPayload(), $result->getStatusCode());
    }
}
