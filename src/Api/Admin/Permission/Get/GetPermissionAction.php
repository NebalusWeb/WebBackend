<?php

namespace Nebalus\Webapi\Api\Admin\Permission\Get;

use Nebalus\Webapi\Api\AbstractAction;
use Slim\Http\Response;
use Slim\Http\ServerRequest as Request;

class GetPermissionAction extends AbstractAction
{
    public function __construct(
        private readonly GetPermissionService $service,
        private readonly GetPermissionValidator $validator
    ) {
    }
    
     /**
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    protected function execute(Request $request, Response $response, array $pathArgs): Response
    {
        $this->validator->validate($request, $pathArgs);

        $userPerms = $request->getAttribute('userPermissionIndex');
        $result = $this->service->execute($this->validator, $userPerms);

        return $response->withJson($result->getPayload(), $result->getStatusCode());
    }
}
