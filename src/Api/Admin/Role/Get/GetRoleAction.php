<?php

namespace Nebalus\Webapi\Api\Admin\Role\Get;

use Nebalus\Webapi\Api\AbstractAction;
use Nebalus\Webapi\Config\Types\PermissionNodesTypes;
use Nebalus\Webapi\Exception\ApiException;
use Nebalus\Webapi\Value\User\AccessControl\Permission\PermissionAccess;
use Nebalus\Webapi\Value\User\AccessControl\Permission\PermissionAccessCollection;
use Slim\Http\Response;
use Slim\Http\ServerRequest as Request;

class GetRoleAction extends AbstractAction
{
    public function __construct(
        private readonly GetRoleService $service,
        private readonly GetRoleValidator $validator
    ) {
    }

    protected function execute(Request $request, Response $response, array $pathArgs): Response
    {
        $this->validator->validate($request, $pathArgs);

        $userPerms = $request->getAttribute('userPermissionIndex');
        $result = $this->service->execute($this->validator, $userPerms);

        return $response->withJson($result->getPayload(), $result->getStatusCode());
    }
}
