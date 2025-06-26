<?php

declare(strict_types=1);

namespace Nebalus\Webapi\Api\Module\Linktree\Delete;

use Nebalus\Webapi\Api\AbstractAction;
use Nebalus\Webapi\Value\User\AccessControl\Permission\PermissionAccessCollection;
use Slim\Http\Response as Response;
use Slim\Http\ServerRequest as Request;

class DeleteLinktreeAction extends AbstractAction
{
    public function __construct(
        private readonly DeleteLinktreeService $service,
    ) {
    }

    protected function endpointAccessGuard(): PermissionAccessCollection
    {
        return PermissionAccessCollection::fromObjects();
    }

    protected function execute(Request $request, Response $response, array $pathArgs): Response
    {
        $params = $request->getParams() ?? [];
        $result = $this->service->execute($params);
        return $response->withJson($result->getPayload(), $result->getStatusCode());
    }
}
