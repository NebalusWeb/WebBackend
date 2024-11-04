<?php

declare(strict_types=1);

namespace Nebalus\Webapi\Api\Action\Referral;

use Nebalus\Webapi\Api\Action\ApiAction;
use Nebalus\Webapi\Api\Service\Referral\ReferralGetService;
use Slim\Http\Response as Response;
use Slim\Http\ServerRequest as Request;

class ReferralGetAction extends ApiAction
{
    public function __construct(
        private readonly ReferralGetService $referralGetService
    )
    {
    }

    protected function execute(Request $request, Response $response, array $args): Response
    {
        $params = $request->getParams() ?? [];
        $result = $this->referralGetService->execute($params);

        return $response->withJson($result->getPayload(), $result->getStatusCode());
    }
}
