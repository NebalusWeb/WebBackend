<?php

declare(strict_types=1);

namespace Nebalus\Webapi\Api\Module\Referral\Edit;

use Nebalus\Webapi\Api\AbstractAction;
use Slim\Http\Response as Response;
use Slim\Http\ServerRequest as Request;

class EditReferralAction extends AbstractAction
{
    public function __construct(
        private readonly EditReferralService $service,
        private readonly EditReferralValidator $validator,
    ) {
    }

    protected function execute(Request $request, Response $response, array $args): Response
    {
        $this->validator->validate($request);
        $result = $this->service->execute($this->validator);
        return $response->withJson($result->getPayload(), $result->getStatusCode());
    }
}
