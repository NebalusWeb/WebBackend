<?php

namespace Nebalus\Webapi\Api\Admin\Role\Create;

use Nebalus\Webapi\Api\AbstractAction;
use Nebalus\Webapi\Api\PrivilegeNodeTypes;
use Nebalus\Webapi\Exception\ApiException;
use Nebalus\Webapi\Value\User\AccessControl\Privilege\PrivilegeNode;
use Nebalus\Webapi\Value\User\AccessControl\Privilege\PrivilegeNodeCollection;
use Slim\Http\Response;
use Slim\Http\ServerRequest as Request;

class CreateRoleAction extends AbstractAction
{
    public function __construct(
        private readonly CreateRoleValidator $validator,
        private readonly CreateRoleService $service
    ) {
    }

    /**
     * @throws ApiException
     */
    protected function accessPrivilegeConfig(): PrivilegeNodeCollection
    {
        return PrivilegeNodeCollection::fromObjects(
            PrivilegeNode::from(PrivilegeNodeTypes::ADMIN_ROLE_CREATE)
        );
    }

    protected function execute(Request $request, Response $response, array $pathArgs): Response
    {
        $this->validator->validate($request, $pathArgs);
        $result = $this->service->execute($this->validator);
        return $response->withJson($result->getPayload(), $result->getStatusCode());
    }
}
