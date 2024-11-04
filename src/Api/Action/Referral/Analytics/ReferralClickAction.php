<?php

declare(strict_types=1);

namespace Nebalus\Webapi\Api\Action\Referral\Analytics;

use DateMalformedStringException;
use Nebalus\Webapi\Api\Action\ApiAction;
use Nebalus\Webapi\Api\Service\Referral\ReferralClickService;
use Slim\Http\Response as Response;
use Slim\Http\ServerRequest as Request;

class ReferralClickAction extends ApiAction
{
    public function __construct(
        private readonly ReferralClickService $referralClickService,
    ) {
    }

    /**
     * @throws DateMalformedStringException
     */
    protected function execute(Request $request, Response $response, array $args): Response
    {
        $result = $this->referralClickService->execute($args);

        return $response->withJson($result->getPayload(), $result->getStatusCode());
    }
}
