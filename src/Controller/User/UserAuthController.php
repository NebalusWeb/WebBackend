<?php

namespace Nebalus\Webapi\Controller\User;

use Nebalus\Webapi\Controller\GenericController;
use Nebalus\Webapi\Service\User\UserAuthService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class UserAuthController implements GenericController
{
    private UserAuthService $userAuthService;

    public function __construct(UserAuthService $userAuthService)
    {
        $this->userAuthService = $userAuthService;
    }

    public function action(Request $request, Response $response, array $args): Response
    {

    }
}
