<?php

namespace Nebalus\Webapi\Api\Admin\Role\Create;

use Nebalus\Webapi\Api\AbstractAction;
use Nebalus\Webapi\Value\User\AccessControl\Privilege\PrivilegeNodeCollection;
use Slim\Http\Response;
use Slim\Http\ServerRequest as Request;

class CreateRoleAction extends AbstractAction
{

    public function __construct(
        private readonly CreateRoleService $service,
        private readonly CreateRoleValidator $validator
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
