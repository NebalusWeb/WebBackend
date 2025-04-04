<?php

namespace Nebalus\Webapi\Api\Admin\Privilege\Get;

use Nebalus\Webapi\Api\AbstractAction;
use Slim\Http\Response;
use Slim\Http\ServerRequest as Request;

class GetPrivilegeAction extends AbstractAction
{
    public function __construct(
        private GetPrivilegeService $service,
        private GetPrivilegeValidator $validator
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
