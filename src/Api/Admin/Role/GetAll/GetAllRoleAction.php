<?php

namespace Nebalus\Webapi\Api\Admin\Role\GetAll;

use Nebalus\Webapi\Api\AbstractAction;
use Nebalus\Webapi\Api\PermissionNodesTypes;
use Nebalus\Webapi\Exception\ApiException;
use Nebalus\Webapi\Value\User\AccessControl\Permission\PermissionNode;
use Nebalus\Webapi\Value\User\AccessControl\Permission\PermissionNodeCollection;
use Slim\Http\Response;
use Slim\Http\ServerRequest as Request;

class GetAllRoleAction extends AbstractAction
{
    public function __construct(
        private readonly GetAllRoleService $service,
        private readonly GetAllRoleValidator $validator
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
        $this->validator->validate($request, $pathArgs);
        $result = $this->service->execute($this->validator);
        return $response->withJson($result->getPayload(), $result->getStatusCode());
    }
}
