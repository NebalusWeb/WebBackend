<?php

declare(strict_types=1);

namespace Nebalus\Webapi\Api\Action\Referral;

use Nebalus\Webapi\Api\Action\ApiAction;
use Nebalus\Webapi\Api\Service\Referral\ReferralEditService;
use Slim\Http\Response as Response;
use Slim\Http\ServerRequest as Request;

class ReferralEditAction extends ApiAction
{
    public function __construct(
        private readonly ReferralEditService $referralEditService
    ) {
    }

    protected function execute(Request $request, Response $response, array $args): Response
    {
        $params = $request->getParams() ?? [];
        $result = $this->referralEditService->execute($params);

        return $response->withJson($result->getPayload(), $result->getStatusCode());
    }
}
