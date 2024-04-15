<?php

namespace Nebalus\Webapi\Controller\Linktree;

use Nebalus\Webapi\Controller\GenericController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class LinktreeGetController implements GenericController
{
    public function __construct()
    {
    }

    public function action(Request $request, Response $response, array $args): Response
    {
        $response->getBody()->write("Linktree Api Read");

        return $response->withStatus(200);
    }
}
