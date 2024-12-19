<?php

declare(strict_types=1);

namespace Nebalus\Webapi\Api\Referral\Analytics\Click;

use Nebalus\Webapi\Api\AbstractAction;
use Slim\Http\Response as Response;
use Slim\Http\ServerRequest as Request;

class ClickReferralAction extends AbstractAction
{
    public function __construct(
        private readonly ClickReferralValidator $validator,
        private readonly ClickReferralService   $service,
    ) {
    }

    protected function execute(Request $request, Response $response, array $args): Response
    {
        $this->validator->validate($request);
        $result = $this->service->execute($this->validator);
        return $response->withJson($result->getPayload(), $result->getStatusCode());
    }
}
