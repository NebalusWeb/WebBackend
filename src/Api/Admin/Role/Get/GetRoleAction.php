<?php

namespace Nebalus\Webapi\Api\Admin\Role\Get;

use Nebalus\Webapi\Api\AbstractAction;
use Nebalus\Webapi\Value\User\AccessControl\Privilege\PrivilegeNodeCollection;
use Slim\Http\Response;
use Slim\Http\ServerRequest as Request;

class GetRoleAction extends AbstractAction
{

    public function __construct(
        private readonly GetRoleService $service,
        private readonly GetRoleValidator $validator
    ) {
    }

    protected function privilegeConfig(): PrivilegeNodeCollection
    {
        return PrivilegeNodeCollection::fromObjects();
    }

    protected function execute(Request $request, Response $response, array $pathArgs): Response
    {

    }
}
