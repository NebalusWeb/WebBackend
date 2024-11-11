<?php

namespace Nebalus\Webapi\Api\Action\User;

use DateMalformedStringException;
use Nebalus\Webapi\Api\Action\ApiAction;
use Nebalus\Webapi\Api\Service\User\UserRegisterService;
use Slim\Http\Response as Response;
use Slim\Http\ServerRequest as Request;

class UserRegisterAction extends ApiAction
{
    public function __construct(
        private readonly UserRegisterService $service
    ) {
    }

    /**
     * @throws DateMalformedStringException
     */
    protected function execute(Request $request, Response $response, array $args): Response
    {
        $bodyParams = $request->getParsedBody() ?? [];
        $result = $this->service->execute($bodyParams);

        return $response->withJson($result->getPayload(), $result->getStatusCode());
    }
}
