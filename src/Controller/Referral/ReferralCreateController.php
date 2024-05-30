<?php

namespace Nebalus\Webapi\Controller\Referral;

use Nebalus\Webapi\Controller\BaseController;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class ReferralCreateController extends BaseController
{
    public function __construct()
    {
    }

    public function action(Request $request, Response $response, array $args): Response
    {
        $response->getBody()->write("ReferralObject Api Create");

        return $response->withStatus(200);
    }
}
