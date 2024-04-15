<?php

namespace Nebalus\Webapi\Controller;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

interface GenericController
{
    public function action(Request $request, Response $response, array $args): Response;
}
