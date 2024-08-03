<?php

declare(strict_types=1);

namespace Nebalus\Webapi\Controller;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class TempController
{
    public function action(Request $request, Response $response, array $args): Response
    {
        $response->getBody()->write("TEST");

        return $response->withStatus(200);
    }
}
