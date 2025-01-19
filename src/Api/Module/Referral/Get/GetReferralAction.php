<?php

declare(strict_types=1);

namespace Nebalus\Webapi\Api\Module\Referral\Get;

use Nebalus\Webapi\Api\AbstractAction;
use Slim\Http\Response as Response;
use Slim\Http\ServerRequest as Request;

class GetReferralAction extends AbstractAction
{
    public function __construct(
        private readonly GetReferralService $service,
        private readonly GetReferralValidator $validator
    ) {
    }

    protected function execute(Request $request, Response $response, array $pathArgs): Response
    {
        $this->validator->validate($request, $pathArgs);

        $result = $this->service->execute($this->validator, $request->getAttribute('user'));

        return $response->withJson($result->getPayload(), $result->getStatus());
    }
}
