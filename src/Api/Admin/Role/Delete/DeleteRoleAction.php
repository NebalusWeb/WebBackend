<?php

namespace Nebalus\Webapi\Api\Admin\Role\Delete;

use Nebalus\Webapi\Api\AbstractAction;
use Slim\Http\Response;
use Slim\Http\ServerRequest as Request;

class DeleteRoleAction extends AbstractAction
{
    public function __construct(
        private readonly DeleteRoleService $service,
        private readonly DeleteRoleValidator $validator
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
