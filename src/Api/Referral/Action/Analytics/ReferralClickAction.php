<?php

declare(strict_types=1);

namespace Nebalus\Webapi\Api\Referral\Action\Analytics;

use Nebalus\Webapi\Api\AbstractAction;
use Nebalus\Webapi\Api\Referral\Service\Analytics\ReferralClickService;
use Nebalus\Webapi\Api\Referral\Validator\Analytics\ReferralClickValidator;
use Slim\Http\Response as Response;
use Slim\Http\ServerRequest as Request;

class ReferralClickAction extends AbstractAction
{
    public function __construct(
        private readonly ReferralClickValidator $validator,
        private readonly ReferralClickService $service,
    ) {
    }

    protected function execute(Request $request, Response $response, array $args): Response
    {
        $this->validator->validate($request);
        $result = $this->service->execute($this->validator);
        return $response->withJson($result->getPayload(), $result->getStatusCode());
    }
}
