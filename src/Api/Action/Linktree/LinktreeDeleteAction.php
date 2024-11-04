<?php

declare(strict_types=1);

namespace Nebalus\Webapi\Api\Action\Referral;

use DateMalformedStringException;
use Nebalus\Webapi\Api\Action\ApiAction;
use Nebalus\Webapi\Api\Service\Referral\LinktreeDeleteService;
use Slim\Http\Response as Response;
use Slim\Http\ServerRequest as Request;

class LinktreeDeleteAction extends ApiAction
{
    public function __construct(
        private readonly LinktreeDeleteService $linktreeDeleteService,
    ) {
    }

    /**
     * @throws DateMalformedStringException
     */
    protected function execute(Request $request, Response $response, array $args): Response
    {
        $params = $request->getParams() ?? [];
        $result = $this->linktreeDeleteService->execute($params);

        return $response->withJson($result->getPayload(), $result->getStatusCode());
    }
}
