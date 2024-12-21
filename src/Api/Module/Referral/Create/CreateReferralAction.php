<?php

declare(strict_types=1);

namespace Nebalus\Webapi\Api\Module\Referral\Create;

use Nebalus\Webapi\Api\AbstractAction;
use Slim\Http\Response as Response;
use Slim\Http\ServerRequest as Request;

class CreateReferralAction extends AbstractAction
{
    public function __construct(
        private readonly CreateReferralService $service,
        private readonly CreateReferralValidator $validator
    ) {
    }

    protected function execute(Request $request, Response $response, array $args): Response
    {
        $this->validator->validate($request, $args);

        $result = $this->service->execute($this->validator);

        return $response->withJson($result->getPayload(), $result->getStatusCode());
    }
}
