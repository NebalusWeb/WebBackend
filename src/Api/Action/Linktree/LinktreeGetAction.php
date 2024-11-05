<?php

declare(strict_types=1);

namespace Nebalus\Webapi\Api\Action\Linktree;

use Nebalus\Webapi\Api\Action\ApiAction;
use Nebalus\Webapi\Api\Service\Linktree\LinktreeGetService;
use Slim\Http\Response as Response;
use Slim\Http\ServerRequest as Request;

class LinktreeGetAction extends ApiAction
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
