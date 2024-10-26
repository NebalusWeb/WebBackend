<?php

namespace Nebalus\Webapi\Api\Action;

use Psr\Http\Message\ResponseInterface as ResponseInterface;
use Slim\Http\Response as Response;
use Slim\Http\ServerRequest as Request;

abstract class ApiAction
{
    public function __invoke(
        Request $request,
        Response $response,
        array $args
    ): ResponseInterface {
        return $this->execute($request, $response, $args);
    }

    abstract protected function execute(
        Request $request,
        Response $response,
        array $args
    ): Response;
}
