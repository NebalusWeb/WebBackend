<?php

namespace Nebalus\Webapi\Api\Admin\Role\Create;

use Nebalus\Webapi\Api\AbstractAction;
use Slim\Http\Response;
use Slim\Http\ServerRequest as Request;

class CreateRoleAction extends AbstractAction
{

    public function __construct(
        private readonly CreateRoleService $service,
        private readonly CreateRoleValidator $validator
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
