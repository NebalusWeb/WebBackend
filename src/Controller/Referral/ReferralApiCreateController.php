<?php

namespace Nebalus\Ownsite\Controller\Referral;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class ReferralApiCreateController
{

    public function __construct()
    {
    }

    public function referral(Request $request, Response $response): Response
    {
        return $response;
    }
}
