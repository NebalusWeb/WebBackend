<?php

declare(strict_types=1);

namespace Nebalus\Webapi\Api\Action\Referral;

use Nebalus\Webapi\Api\Action\ApiAction;
use Nebalus\Webapi\Api\Service\Referral\ReferralGetService;
use Nebalus\Webapi\Api\Validator\Referral\ReferralGetValidator;
use Slim\Http\Response as Response;
use Slim\Http\ServerRequest as Request;

class ReferralGetAction extends ApiAction
{
    public function __construct(
        private readonly ReferralGetService $service,
        private readonly ReferralGetValidator $validator
    ) {
    }

    protected function execute(Request $request, Response $response, array $args): Response
    {
        $this->validator->validate($request);
        $result = $this->service->execute($this->validator);
        return $response->withJson($result->getPayload(), $result->getStatusCode());
    }
}
