<?php

namespace Nebalus\Webapi\Controller\Account;

use Nebalus\Webapi\Service\Account\AccountLoginService;
use Nebalus\Webapi\ValueObject\JsonResponse;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class AccountLoginController
{
    private JsonResponse $httpBodyJsonResponse;
    private AccountLoginService $accountLoginService;

    public function __construct(JsonResponse $httpBodyJsonResponse, AccountLoginService $accountLoginService)
    {
        $this->httpBodyJsonResponse = $httpBodyJsonResponse;
        $this->accountLoginService = $accountLoginService;
    }

    public function action(Request $request, Response $response, array $args): Response
    {

    }
}
