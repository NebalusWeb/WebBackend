<?php

declare(strict_types=1);

namespace Nebalus\Webapi\Api\Linktree\Action;

use Nebalus\Webapi\Api\AbstractAction;
use Nebalus\Webapi\Api\Linktree\Service\LinktreeEditService;
use Slim\Http\Response as Response;
use Slim\Http\ServerRequest as Request;

class LinktreeEditAction extends AbstractAction
{
    public function __construct(
        private readonly LinktreeEditService $linktreeEditService,
    ) {
    }

    protected function execute(Request $request, Response $response, array $args): Response
    {
        $params = $request->getParams() ?? [];
        $result = $this->linktreeEditService->execute($params);

        return $response->withJson($result->getPayload(), $result->getStatusCode());
    }
}
