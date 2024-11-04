<?php

declare(strict_types=1);

namespace Nebalus\Webapi\Api\Action\Referral;

use Nebalus\Webapi\Api\Action\ApiAction;
use Nebalus\Webapi\Api\Service\Referral\ReferralCreateService;
use Slim\Http\Response as Response;
use Slim\Http\ServerRequest as Request;

class ReferralCreateAction extends ApiAction
{
    public function __construct(
        private readonly ReferralCreateService $referralCreateService
    )
    {
    }

    protected function execute(Request $request, Response $response, array $args): Response
    {
        $params = $request->getParams() ?? [];
        $result = $this->referralCreateService->execute($params);

        return $response->withJson($result->getPayload(), $result->getStatusCode());
    }
}
