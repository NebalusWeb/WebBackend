<?php

namespace Nebalus\Webapi\Api\Admin\Role\Edit;

use Nebalus\Webapi\Api\AbstractAction;
use Slim\Http\Response;
use Slim\Http\ServerRequest as Request;

class EditRoleAction extends AbstractAction
{

    public function __construct(
        private readonly EditRoleService $service,
        private readonly EditRoleValidator $validator
    ) {
    }

    protected function privilegeCheck(): bool
    {
        // TODO: Implement privilegeCheck() method.
    }

    protected function execute(Request $request, Response $response, array $pathArgs): Response
    {
        // TODO: Implement execute() method.
    }
}
