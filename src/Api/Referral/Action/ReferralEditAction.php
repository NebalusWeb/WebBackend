<?php

declare(strict_types=1);

namespace Nebalus\Webapi\Api\Referral\Action;

use Nebalus\Webapi\Api\AbstractAction;
use Nebalus\Webapi\Api\Referral\Service\ReferralEditService;
use Nebalus\Webapi\Api\Referral\Validator\ReferralEditValidator;
use Slim\Http\Response as Response;
use Slim\Http\ServerRequest as Request;

class ReferralEditAction extends AbstractAction
{
    public function __construct(
        private readonly ReferralEditService $service,
        private readonly ReferralEditValidator $validator,
    ) {
    }

    protected function execute(Request $request, Response $response, array $args): Response
    {
        $this->validator->validate($request);
        $result = $this->service->execute($this->validator);
        return $response->withJson($result->getPayload(), $result->getStatusCode());
    }
}
