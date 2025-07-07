<?php

namespace Nebalus\Webapi\Api\Admin\Permission\GetAll;

use Nebalus\Webapi\Api\AbstractAction;
use Nebalus\Webapi\Config\Types\PermissionNodesTypes;
use Nebalus\Webapi\Exception\ApiException;
use Nebalus\Webapi\Value\User\AccessControl\Permission\PermissionAccess;
use Nebalus\Webapi\Value\User\AccessControl\Permission\PermissionAccessCollection;
use Slim\Http\Response;
use Slim\Http\ServerRequest as Request;

class GetAllPermissionAction extends AbstractAction
{
    public function __construct(
        private GetAllPermissionService $service,
    ) {
    }

    /**
     * @throws ApiException
     */
    protected function endpointAccessGuard(): PermissionAccessCollection
    {
        return PermissionAccessCollection::fromObjects(
            PermissionAccess::from(PermissionNodesTypes::ADMIN_ROLE, true)
        );
    }

    protected function execute(Request $request, Response $response, array $pathArgs): Response
    {
        $userPerms = $request->getAttribute('userPermissionIndex');
        $result = $this->service->execute($userPerms);

        return $response->withJson($result->getPayload(), $result->getStatusCode());
    }
}
