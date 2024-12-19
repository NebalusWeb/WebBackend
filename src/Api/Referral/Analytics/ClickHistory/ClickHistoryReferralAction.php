<?php

namespace Nebalus\Webapi\Api\Referral\Analytics\ClickHistory;

use DateMalformedStringException;
use Nebalus\Webapi\Api\AbstractAction;
use Nebalus\Webapi\Api\Referral\Analytics\Click\ClickReferralService;
use Slim\Http\Response as Response;
use Slim\Http\ServerRequest as Request;

class ClickHistoryReferralAction extends AbstractAction
{
    public function __construct(
        private readonly ClickReferralService $referralClickService,
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
