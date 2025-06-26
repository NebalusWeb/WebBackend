<?php

namespace Nebalus\Webapi\Api\Admin\Permission\Get;

use Nebalus\Webapi\Api\AbstractAction;
use Nebalus\Webapi\Config\Types\PermissionNodesTypes;
use Nebalus\Webapi\Exception\ApiException;
use Nebalus\Webapi\Value\User\AccessControl\Permission\PermissionAccess;
use Nebalus\Webapi\Value\User\AccessControl\Permission\PermissionAccessCollection;
use Slim\Http\Response;
use Slim\Http\ServerRequest as Request;

class GetPermissionAction extends AbstractAction
{
    public function __construct(
        private readonly GetPermissionService $service,
        private readonly GetPermissionValidator $validator
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
        $this->validator->validate($request, $pathArgs);
        $result = $this->service->execute($this->validator);
        return $response->withJson($result->getPayload(), $result->getStatusCode());
    }
}
