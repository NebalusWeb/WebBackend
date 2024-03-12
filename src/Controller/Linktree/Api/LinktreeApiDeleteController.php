<?php

namespace Nebalus\Webapi\Controller\Linktree\Api;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class LinktreeApiDeleteController
{
    public function action(Request $request, Response $response, array $args): Response
    {
        $response->getBody()->write("Linktree Api Delete");

        return $response->withStatus(200);
    }
}
