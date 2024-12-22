<?php

declare(strict_types=1);

namespace Nebalus\Webapi\Api\Module\Linktree\Create;

use Nebalus\Webapi\Api\AbstractAction;
use Slim\Http\Response as Response;
use Slim\Http\ServerRequest as Request;

class CreateLinktreeAction extends AbstractAction
{
    public function __construct(
        private readonly CreateLinktreeService $service,
    ) {
    }

    protected function execute(Request $request, Response $response, array $pathArgs): Response
    {
        $params = $request->getParams() ?? [];

        $result = $this->service->execute($params);

        return $response->withJson($result->getPayload(), $result->getStatusCode());
    }
}
