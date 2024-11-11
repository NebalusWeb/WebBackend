<?php

declare(strict_types=1);

namespace Nebalus\Webapi\Api\Action\Linktree\Analytics;

use Nebalus\Webapi\Api\Action\ApiAction;
use Nebalus\Webapi\Api\Service\Linktree\Analytics\LinktreeClickService;
use Slim\Http\Response as Response;
use Slim\Http\ServerRequest as Request;

class LinktreeClickAction extends ApiAction
{
    public function __construct(
        private readonly LinktreeClickService $linktreeClickService,
    ) {
    }

    protected function execute(Request $request, Response $response, array $args): Response
    {
        $params = $request->getParams() ?? [];
        $result = $this->linktreeClickService->execute($params);

        return $response->withJson($result->getPayload(), $result->getStatusCode());
    }
}
