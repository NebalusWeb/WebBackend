<?php

declare(strict_types=1);

namespace Nebalus\Webapi\Api\Action\Referral;

use Nebalus\Webapi\Api\Action\ApiAction;
use Nebalus\Webapi\Api\Service\Referral\ReferralCreateService;
use Nebalus\Webapi\Api\Service\Referral\ReferralListallService;
use Slim\Http\Response as Response;
use Slim\Http\ServerRequest as Request;

class ReferralListallAction extends ApiAction
{
    public function __construct(
        private readonly ReferralListallService $referralListallService
    )
    {
    }

    protected function execute(Request $request, Response $response, array $args): Response
    {
        $params = $request->getParams() ?? [];
        $result = $this->referralListallService->execute($params);

        return $response->withJson($result->getPayload(), $result->getStatusCode());
    }
}
