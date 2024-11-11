<?php

declare(strict_types=1);

namespace Nebalus\Webapi\Api\Action\Linktree;

use Nebalus\Webapi\Api\Action\ApiAction;
use Nebalus\Webapi\Api\Service\Linktree\LinktreeEditService;
use Slim\Http\Response as Response;
use Slim\Http\ServerRequest as Request;

class LinktreeEditAction extends ApiAction
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
