<?php

namespace Nebalus\Ownsite\Controller\Linktree\Api;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class LinktreeApiUpdateController
{

    public function action(Request $request, Response $response, array $args): Response
    {
        $response->getBody()->write("Linktree Api Update");

        return $response->withStatus(200);
    }

}
