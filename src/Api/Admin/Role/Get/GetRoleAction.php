<?php

namespace Nebalus\Webapi\Api\Admin\Role\Get;

use Nebalus\Webapi\Api\AbstractAction;
use Slim\Http\Response;
use Slim\Http\ServerRequest as Request;

class GetRoleAction extends AbstractAction
{

    public function __construct(
        private readonly GetRoleService $service,
        private readonly GetRoleValidator $validator
    ) {
    }

    protected function execute(Request $request, Response $response, array $pathArgs): Response
    {
        // TODO: Implement execute() method.
    }
}
