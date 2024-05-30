<?php

namespace Nebalus\Webapi\Controller;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

abstract class BaseController
{
    abstract protected function action(Request $request, Response $response, array $args): Response;

    public function entryAction(Request $request, Response $response, array $args): Response
    {
        $response = $this->action($request, $response, $args);

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withHeader('Access-Control-Allow-Origin', '*');
    }
}
