<?php

namespace Nebalus\Webapi\Api\User\GetUserPermissions;

use Nebalus\Webapi\Api\AbstractAction;
use Slim\Http\Response;
use Slim\Http\ServerRequest as Request;

class GetUserPermissionsAction extends AbstractAction
{
    public function __construct(
        private readonly GetUserPermissionsService $service,
        private readonly GetUserPermissionsValidator $validator
    ) {
    }

    /**
     * @inheritDoc
     */
    protected function execute(Request $request, Response $response, array $pathArgs): Response
    {
        $this->validator->validate($request, $pathArgs);
        $requestingUser = $request->getAttribute('requestingUser');
        $userPermissionIndex = $request->getAttribute('userPermissionIndex');
        $result = $this->service->execute($this->validator, $requestingUser, $userPermissionIndex);
        return $response->withJson($result->getPayload(), $result->getStatusCode());
    }
}
