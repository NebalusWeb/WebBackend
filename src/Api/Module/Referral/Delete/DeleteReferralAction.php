<?php

declare(strict_types=1);

namespace Nebalus\Webapi\Api\Module\Referral\Delete;

use Nebalus\Webapi\Api\AbstractAction;
use Slim\Http\Response as Response;
use Slim\Http\ServerRequest as Request;

class DeleteReferralAction extends AbstractAction
{
    public function __construct(
        private readonly DeleteReferralService $service,
        private readonly DeleteReferralValidator $validator
    ) {
    }

    protected function execute(Request $request, Response $response, array $args): Response
    {
        $this->validator->validate($request);
        $result = $this->service->execute($this->validator);
        return $response->withJson($result->getPayload(), $result->getStatusCode());
    }
}
