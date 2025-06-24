<?php

namespace Nebalus\Webapi\Api\User\GetUserPrivileges;

use Nebalus\Webapi\Api\AbstractAction;
use Nebalus\Webapi\Value\User\AccessControl\Permission\PermissionNodeCollection;
use Slim\Http\Response;
use Slim\Http\ServerRequest as Request;

class GetUserPermissionsAction extends AbstractAction
{
    public function __construct(
        private readonly GetUserPermissionsService $service,
        private readonly GetUserPermissionsValidator $validator
    ) {
    }

    protected function accessPermissionConfig(): ?PermissionNodeCollection
    {
        return null;
    }

    /**
     * @inheritDoc
     */
    protected function execute(Request $request, Response $response, array $pathArgs): Response
    {
        $this->validator->validate($request, $pathArgs);
        $result = $this->service->execute($this->validator);
        return $response->withJson($result->getPayload(), $result->getStatusCode());
    }
}
