<?php

namespace Nebalus\Webapi\Controller\Linktree\Api;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class LinktreeApiReadController
{
    public function action(Request $request, Response $response, array $args): Response
    {
        $response->getBody()->write("Linktree Api Read");

        return $response->withStatus(200);
    }
}
