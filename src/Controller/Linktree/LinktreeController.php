<?php

namespace Nebalus\Ownsite\Controller\Linktree;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class LinktreeController
{
    public function action(Request $request, Response $response): Response
    {
        $response->getBody()->write("Linktree");

        return $response->withStatus(200);
    }

}