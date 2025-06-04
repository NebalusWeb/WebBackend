<?php

namespace Nebalus\Webapi\Api\Module\Referral\Analytics\ClickHistory;

use Nebalus\Webapi\Api\AbstractAction;
use Nebalus\Webapi\Value\User\AccessControl\Privilege\Entity\PrivilegeNodeCollection;
use Slim\Http\Response as Response;
use Slim\Http\ServerRequest as Request;

class ClickHistoryReferralAction extends AbstractAction
{
    public function __construct(
        private readonly ClickHistoryReferralService $service,
        private readonly ClickHistoryReferralValidator $validator
    ) {
    }

    protected function privilegeConfig(): PrivilegeNodeCollection
    {
        return PrivilegeNodeCollection::fromObjects();
    }

    protected function execute(Request $request, Response $response, array $pathArgs): Response
    {
        $this->validator->validate($request, $pathArgs);

        $result = $this->service->execute($this->validator, $request->getAttribute('user'));

        return $response->withJson($result->getPayload(), $result->getStatusCode());
    }
}
