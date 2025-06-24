<?php

namespace Nebalus\Webapi\Api\Admin\Permission\GetAll;

use Nebalus\Webapi\Api\AbstractAction;
use Nebalus\Webapi\Api\PermissionNodesTypes;
use Nebalus\Webapi\Exception\ApiException;
use Nebalus\Webapi\Value\User\AccessControl\Permission\PermissionNode;
use Nebalus\Webapi\Value\User\AccessControl\Permission\PermissionNodeCollection;
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
    protected function accessPermissionConfig(): PermissionNodeCollection
    {
        return PermissionNodeCollection::fromObjects(
            PermissionNode::from(PermissionNodesTypes::ADMIN_ROLE)
        );
    }

    protected function execute(Request $request, Response $response, array $pathArgs): Response
    {
        $result = $this->service->execute();
        return $response->withJson($result->getPayload(), $result->getStatusCode());
    }
}
