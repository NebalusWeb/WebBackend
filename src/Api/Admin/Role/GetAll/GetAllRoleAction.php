<?php

namespace Nebalus\Webapi\Api\Admin\Role\GetAll;

use Nebalus\Webapi\Api\AbstractAction;
use Nebalus\Webapi\Value\User\AccessControl\Privilege\PrivilegeNodeCollection;
use Slim\Http\Response;
use Slim\Http\ServerRequest as Request;

class GetAllRoleAction extends AbstractAction
{
    public function __construct(
        private readonly GetAllRoleService $service,
        private readonly GetAllRoleValidator $validator
    ) {
    }

    protected function privilegeConfig(): PrivilegeNodeCollection
    {
        return PrivilegeNodeCollection::fromObjects();
    }

    protected function execute(Request $request, Response $response, array $pathArgs): Response
    {
        // TODO: Implement execute() method.
    }
}
