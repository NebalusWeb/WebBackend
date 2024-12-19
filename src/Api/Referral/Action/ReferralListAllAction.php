<?php

declare(strict_types=1);

namespace Nebalus\Webapi\Api\Referral\Action;

use Nebalus\Webapi\Api\AbstractAction;
use Nebalus\Webapi\Api\Referral\Service\ReferralListAllService;
use Nebalus\Webapi\Api\Referral\Validator\ReferralListAllValidator;
use Slim\Http\Response as Response;
use Slim\Http\ServerRequest as Request;

class ReferralListAllAction extends AbstractAction
{
    public function __construct(
        private readonly ReferralListAllService $service,
        private readonly ReferralListAllValidator $validator
    ) {
    }

    protected function execute(Request $request, Response $response, array $args): Response
    {
        $this->validator->validate($request);
        $result = $this->service->execute($this->validator);
        return $response->withJson($result->getPayload(), $result->getStatusCode());
    }
}
