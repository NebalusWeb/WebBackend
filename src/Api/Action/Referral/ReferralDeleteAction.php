<?php

declare(strict_types=1);

namespace Nebalus\Webapi\Api\Action\Referral;

use Nebalus\Webapi\Api\Action\ApiAction;
use Nebalus\Webapi\Api\Service\Referral\ReferralDeleteService;
use Nebalus\Webapi\Api\Validator\Referral\ReferralDeleteValidator;
use Slim\Http\Response as Response;
use Slim\Http\ServerRequest as Request;

class ReferralDeleteAction extends ApiAction
{
    public function __construct(
        private readonly ReferralDeleteService $service,
        private readonly ReferralDeleteValidator $validator
    ) {
    }

    protected function execute(Request $request, Response $response, array $args): Response
    {
        $this->validator->validate($request);
        $result = $this->service->execute($this->validator);
        return $response->withJson($result->getPayload(), $result->getStatusCode());
    }
}
