<?php

namespace Nebalus\Webapi\Controller;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class DocsController
{
    public function action(Request $request, Response $response, array $args): Response
    {
        $response->getBody()->write("Docs");

        return $response->withStatus(200);
    }
}
