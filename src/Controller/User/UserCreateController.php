<?php

namespace Nebalus\Webapi\Controller\User;

use Nebalus\Webapi\Controller\GenericController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class UserCreateController implements GenericController
{
    public function action(Request $request, Response $response, array $args): Response
    {
        var_dump($request->getAttribute("isAdmin"));

        return new \Slim\Psr7\Response(200);
    }
}
