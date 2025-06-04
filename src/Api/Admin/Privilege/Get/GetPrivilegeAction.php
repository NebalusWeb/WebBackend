<?php

namespace Nebalus\Webapi\Api\Admin\Privilege\Get;

use Nebalus\Webapi\Api\AbstractAction;
use Nebalus\Webapi\Value\User\AccessControl\Privilege\PrivilegeNodeCollection;
use Nebalus\Webapi\Value\User\AccessControl\Privilege\PrivilegeRoleLinkCollection;
use Slim\Http\Response;
use Slim\Http\ServerRequest as Request;

class GetPrivilegeAction extends AbstractAction
{
    public function __construct(
        private readonly GetPrivilegeService $service,
        private readonly GetPrivilegeValidator $validator
    ) {
    }

    protected function privilegeConfig(): PrivilegeNodeCollection
    {
        return PrivilegeNodeCollection::fromObjects();
    }

    protected function execute(Request $request, Response $response, array $pathArgs): Response
    {
        $this->validator->validate($request, $pathArgs);
        $result = $this->service->execute($this->validator);
        return $response->withJson($result->getPayload(), $result->getStatusCode());
    }
}
