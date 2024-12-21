<?php

namespace Nebalus\Webapi\Api\Module\Referral\Analytics\ClickHistory;

use DateMalformedStringException;
use Nebalus\Webapi\Api\AbstractAction;
use Nebalus\Webapi\Api\Module\Referral\Analytics\Click\ClickReferralService;
use Slim\Http\Response as Response;
use Slim\Http\ServerRequest as Request;

class ClickHistoryReferralAction extends AbstractAction
{
    public function __construct(
        private readonly ClickHistoryReferralService $service,
        private readonly ClickHistoryReferralValidator $validator
    ) {
    }

    protected function execute(Request $request, Response $response, array $args): Response
    {
        $this->validator->validate($request, $args);

        $result = $this->service->execute($this->validator);

        return $response->withJson($result->getPayload(), $result->getStatusCode());
    }
}
