<?php

declare(strict_types=1);

namespace Nebalus\Webapi\Api\Linktree\Analytics\Click;

use Nebalus\Webapi\Api\AbstractAction;
use Slim\Http\Response as Response;
use Slim\Http\ServerRequest as Request;

class ClickLinktreeAction extends AbstractAction
{
    public function __construct(
        private readonly ClickLinktreeService $linktreeClickService,
    ) {
    }

    protected function execute(Request $request, Response $response, array $args): Response
    {
        $params = $request->getParams() ?? [];
        $result = $this->linktreeClickService->execute($params);

        return $response->withJson($result->getPayload(), $result->getStatusCode());
    }
}
