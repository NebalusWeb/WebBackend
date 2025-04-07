<?php

declare(strict_types=1);

namespace Nebalus\Webapi\Api\Module\Linktree\Get;

use Nebalus\Webapi\Api\AbstractAction;
use Nebalus\Webapi\Value\User\AccessControl\Privilege\PrivilegeNodeCollection;
use Slim\Http\Response as Response;
use Slim\Http\ServerRequest as Request;

class GetLinktreeAction extends AbstractAction
{
    public function __construct(
        private readonly GetLinktreeService $service,
    ) {
    }

    protected function privilegeConfig(): PrivilegeNodeCollection
    {
        return PrivilegeNodeCollection::fromArray();
    }

    protected function execute(Request $request, Response $response, array $pathArgs): Response
    {
        $params = $request->getParams() ?? [];

        $result = $this->service->execute($params);

        return $response->withJson($result->getPayload(), $result->getStatusCode());
    }
}
