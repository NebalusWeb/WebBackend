<?php

namespace Nebalus\Webapi\Api\Admin\Privilege\GetAll;

use Nebalus\Webapi\Api\AbstractAction;
use Slim\Http\Response;
use Slim\Http\ServerRequest as Request;

class GetAllPrivilegeAction extends AbstractAction
{

    public function __construct(
        private GetAllPrivilegeService $service,
        private GetAllPrivilegeValidator $validator
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
