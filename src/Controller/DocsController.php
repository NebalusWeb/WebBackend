<?php

namespace Nebalus\Ownsite\Controller;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class DocsController
{
    public function action(Request $request, Response $response, array $args): Response
    {
        $response->getBody()->write("Docs");

        return $response->withStatus(200);
    }

}