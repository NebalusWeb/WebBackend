<?php

namespace Nebalus\Webapi\Controller\User;

use Nebalus\Webapi\Controller\GenericController;
use Nebalus\Webapi\Service\User\UserLoginService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class UserLoginController implements GenericController
{
    private UserLoginService $userLoginService;

    public function __construct(UserLoginService $userLoginService)
    {
        $this->userLoginService = $userLoginService;
    }

    public function action(Request $request, Response $response, array $args): Response
    {

    }
}
