<?php

declare(strict_types=1);

namespace Nebalus\Webapi\Api\Linktree\Action;

use Nebalus\Webapi\Api\AbstractAction;
use Nebalus\Webapi\Api\Linktree\Service\LinktreeGetService;
use Slim\Http\Response as Response;
use Slim\Http\ServerRequest as Request;

class LinktreeGetAction extends AbstractAction
{
    public function __construct(
        private readonly LinktreeGetService $linktreeGetService,
    ) {
    }


    protected function execute(Request $request, Response $response, array $args): Response
    {
        $params = $request->getParams() ?? [];
        $result = $this->linktreeGetService->execute($params);

        return $response->withJson($result->getPayload(), $result->getStatusCode());
    }
}
