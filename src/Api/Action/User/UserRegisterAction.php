<?php

namespace Nebalus\Webapi\Api\Action\User;

use DateMalformedStringException;
use Nebalus\Webapi\Api\Action\ApiAction;
use Nebalus\Webapi\Api\Service\User\UserRegisterService;
use Nebalus\Webapi\Exception\ApiInvalidArgumentException;
use Nebalus\Webapi\Option\EnvData;
use Slim\Http\Response as Response;
use Slim\Http\ServerRequest as Request;

class UserRegisterAction extends ApiAction
{
    public function __construct(
        private EnvData $envData,
    ) {
    }

    /**
     * @throws ApiInvalidArgumentException|DateMalformedStringException
     */
    protected function execute(Request $request, Response $response, array $args): Response
    {
        throw new ApiInvalidArgumentException('Not implemented');
        $bodyParams = $request->getParsedBody() ?? [];


        return $response->withJson($result->getPayload(), $result->getStatusCode());
    }
}
