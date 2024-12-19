<?php

declare(strict_types=1);

namespace Nebalus\Webapi\Api\Referral\ListAll;

use Nebalus\Webapi\Api\AbstractAction;
use Slim\Http\Response as Response;
use Slim\Http\ServerRequest as Request;

class ListAllReferralAction extends AbstractAction
{
    public function __construct(
        private readonly ListAllReferralService $service,
        private readonly ListAllReferralValidator $validator
    ) {
    }

    protected function execute(Request $request, Response $response, array $args): Response
    {
        $this->validator->validate($request);
        $result = $this->service->execute($this->validator);
        return $response->withJson($result->getPayload(), $result->getStatusCode());
    }
}
