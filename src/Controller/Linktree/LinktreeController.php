<?php

namespace Nebalus\Webapi\Controller\Linktree;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class LinktreeController
{
    public function action(Request $request, Response $response, array $args): Response
    {
        $response->getBody()->write("Linktree");

        return $response->withStatus(200);
    }
}
