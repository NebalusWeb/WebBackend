<?php

declare(strict_types=1);

namespace Nebalus\Webapi\Api\Module\Linktree\Get;

use Nebalus\Webapi\Api\AbstractAction;
use Slim\Http\Response as Response;
use Slim\Http\ServerRequest as Request;

class GetLinktreeAction extends AbstractAction
{
    public function __construct(
        private readonly GetLinktreeService $service,
    ) {
    }


    protected function execute(Request $request, Response $response, array $args): Response
    {
        $params = $request->getParams() ?? [];

        $result = $this->service->execute($params);

        return $response->withJson($result->getPayload(), $result->getStatusCode());
    }
}
