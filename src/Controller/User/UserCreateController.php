<?php

declare(strict_types=1);

namespace Nebalus\Webapi\Controller\User;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class UserCreateController
{
    public function action(Request $request, Response $response, array $args): Response
    {
        var_dump($request->getAttribute("isAdmin"));

        return new \Slim\Psr7\Response(200);
    }
}
