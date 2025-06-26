<?php

declare(strict_types=1);

namespace Nebalus\Webapi\Api\Module\Linktree\Click;

use Nebalus\Webapi\Api\AbstractAction;
use Nebalus\Webapi\Value\User\AccessControl\Permission\PermissionAccessCollection;
use Slim\Http\Response as Response;
use Slim\Http\ServerRequest as Request;

class ClickLinktreeAction extends AbstractAction
{
    public function __construct(
        private readonly ClickLinktreeService $service,
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
