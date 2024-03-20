<?php

namespace Nebalus\Webapi\Controller\Account;

use Nebalus\Webapi\Service\Account\AccountLoginService;
use Nebalus\Webapi\ValueObjects\HttpBodyJsonResponse;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class AccountLoginController
{
    private HttpBodyJsonResponse $httpBodyJsonResponse;
    private AccountLoginService $accountLoginService;

    public function __construct(HttpBodyJsonResponse $httpBodyJsonResponse, AccountLoginService $accountLoginService)
    {
        $this->httpBodyJsonResponse = $httpBodyJsonResponse;
        $this->accountLoginService = $accountLoginService;
    }

    public function action(Request $request, Response $response, array $args): Response
    {
        $request
    }
}
