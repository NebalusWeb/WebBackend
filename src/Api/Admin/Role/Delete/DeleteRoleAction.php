<?php

namespace Nebalus\Webapi\Api\Admin\Role\Delete;

use Nebalus\Webapi\Api\AbstractAction;
use Nebalus\Webapi\Value\User\AccessControl\Privilege\PrivilegeNodeCollection;
use Slim\Http\Response;
use Slim\Http\ServerRequest as Request;

class DeleteRoleAction extends AbstractAction
{
    public function __construct(
        private readonly DeleteRoleService $service,
        private readonly DeleteRoleValidator $validator
    ) {
    }

    protected function privilegeConfig(): PrivilegeNodeCollection
    {
        return PrivilegeNodeCollection::fromArray();
    }

    protected function execute(Request $request, Response $response, array $pathArgs): Response
    {
        // TODO: Implement execute() method.
    }
}
