<?php

declare(strict_types=1);

namespace Nebalus\Webapi\Api\Action\Referral;

use DateMalformedStringException;
use Nebalus\Webapi\Api\Action\ApiAction;
use Nebalus\Webapi\Api\Service\Referral\LinktreeEditService;
use Slim\Http\Response as Response;
use Slim\Http\ServerRequest as Request;

class LinktreeEditAction extends ApiAction
{
    public function __construct(
        private readonly LinktreeEditService $linktreeEditService,
    ) {
    }

    /**
     * @throws DateMalformedStringException
     */
    protected function execute(Request $request, Response $response, array $args): Response
    {
        $params = $request->getParams() ?? [];
        $result = $this->linktreeEditService->execute($params);

        return $response->withJson($result->getPayload(), $result->getStatusCode());
    }
}
