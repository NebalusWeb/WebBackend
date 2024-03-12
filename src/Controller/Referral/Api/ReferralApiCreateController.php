<?php

namespace Nebalus\Webapi\Controller\Referral\Api;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class ReferralApiCreateController
{
    public function __construct()
    {
    }

    public function action(Request $request, Response $response, array $args): Response
    {
        $response->getBody()->write("Referral Api Create");

        return $response->withStatus(200);
    }
}
