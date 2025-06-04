<?php

declare(strict_types=1);

namespace Nebalus\Webapi\Api\Module\Linktree\Click;

use Nebalus\Webapi\Api\AbstractAction;
use Nebalus\Webapi\Value\User\AccessControl\Privilege\PrivilegeNodeCollection;
use Nebalus\Webapi\Value\User\AccessControl\Privilege\PrivilegeRoleLinkCollection;
use Slim\Http\Response as Response;
use Slim\Http\ServerRequest as Request;

class ClickLinktreeAction extends AbstractAction
{
    public function __construct(
        private readonly ClickLinktreeService $service,
    ) {
    }

    protected function privilegeConfig(): PrivilegeNodeCollection
    {
        return PrivilegeNodeCollection::fromObjects();
    }

    protected function execute(Request $request, Response $response, array $pathArgs): Response
    {
        $params = $request->getParams() ?? [];

        $result = $this->service->execute($params);

        return $response->withJson($result->getPayload(), $result->getStatusCode());
    }
}
