<?php

declare(strict_types=1);

namespace Nebalus\Webapi\Api\Module\Referral\Delete;

use Nebalus\Webapi\Api\AbstractAction;
use Nebalus\Webapi\Value\User\AccessControl\Privilege\PrivilegeNodeCollection;
use Slim\Http\Response as Response;
use Slim\Http\ServerRequest as Request;

class DeleteReferralAction extends AbstractAction
{
    public function __construct(
        private readonly DeleteReferralService $service,
        private readonly DeleteReferralValidator $validator
    ) {
    }

    protected function accessPrivilegeConfig(): PrivilegeNodeCollection
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
