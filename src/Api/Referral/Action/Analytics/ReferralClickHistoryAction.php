<?php

namespace Nebalus\Webapi\Api\Referral\Action\Analytics;

use DateMalformedStringException;
use Nebalus\Webapi\Api\AbstractAction;
use Nebalus\Webapi\Api\Action\Referral\Analytics\ReferralClick;
use Slim\Http\Response as Response;
use Slim\Http\ServerRequest as Request;

class ReferralClickHistoryAction extends AbstractAction
{
    public function __construct(
        private readonly ReferralClick $referralClickService,
    ) {
    }

    /**
     * @throws DateMalformedStringException
     */
    protected function execute(Request $request, Response $response, array $args): Response
    {
        $params = $request->getParams() ?? [];
        $result = $this->referralClickService->execute($params);

        return $response->withJson($result->getPayload(), $result->getStatusCode());
    }
}
