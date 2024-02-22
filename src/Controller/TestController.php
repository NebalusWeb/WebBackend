<?php

namespace Nebalus\Ownsite\Controller;

use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class TestController
{

    public function action(Request $request, Response $response): Response
    {
        $response->getBody()->write("TEST");

        return $response->withStatus(200);
    }

}
