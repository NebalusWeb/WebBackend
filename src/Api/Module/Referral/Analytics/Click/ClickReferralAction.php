<?php

declare(strict_types=1);

namespace Nebalus\Webapi\Api\Module\Referral\Analytics\Click;

use Nebalus\Webapi\Api\AbstractAction;
use Nebalus\Webapi\Value\User\AccessControl\Privilege\PrivilegeNodeCollection;
use Nebalus\Webapi\Value\User\AccessControl\Privilege\PrivilegeRoleLinkCollection;
use Slim\Http\Response as Response;
use Slim\Http\ServerRequest as Request;

class ClickReferralAction extends AbstractAction
{
    public function __construct(
        private readonly ClickReferralValidator $validator,
        private readonly ClickReferralService $service,
    ) {
    }

    protected function privilegeConfig(): PrivilegeNodeCollection
    {
        return PrivilegeNodeCollection::fromObjects();
    }

    protected function execute(Request $request, Response $response, array $pathArgs): Response
    {
        $this->validator->validate($request, $pathArgs);

        $result = $this->service->execute($this->validator);

        return $response->withJson($result->getPayload(), $result->getStatusCode());
    }
}
