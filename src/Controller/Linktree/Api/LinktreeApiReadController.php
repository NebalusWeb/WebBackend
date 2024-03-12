<?php

namespace Nebalus\Ownsite\Controller\Linktree\Api;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class LinktreeApiReadController
{

    public function action(Request $request, Response $response, array $args): Response
    {
        $response->getBody()->write("Linktree Api Read");

        return $response->withStatus(200);
    }

}
