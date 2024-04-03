<?php

namespace Nebalus\Webapi\Controller\Account;

use Nebalus\Webapi\Service\Account\AccountLoginService;
use Nebalus\Webapi\ValueObject\ApiResponse\JsonResponse;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class AccountLoginController
{
    private AccountLoginService $accountLoginService;

    public function __construct(AccountLoginService $accountLoginService)
    {
        $this->accountLoginService = $accountLoginService;
    }

    public function action(Request $request, Response $response, array $args): Response
    {

    }
}
