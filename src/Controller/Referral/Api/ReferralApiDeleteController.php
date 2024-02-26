<?php

namespace Nebalus\Ownsite\Controller\Referral\Api;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class ReferralApiDeleteController
{
    public function __construct()
    {
    }

    public function action(Request $request, Response $response): Response
    {
        $response->getBody()->write("Referral Api Delete");

        return $response->withStatus(200);
    }
}
