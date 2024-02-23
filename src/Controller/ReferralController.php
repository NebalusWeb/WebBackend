<?php

namespace Nebalus\Ownsite\Controller;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class ReferralController
{

    public function referral(Request $request, Response $response): Response
    {
        $queryParams = $request->getQueryParams();
        $response = $response->withStatus(307);
        if(!key_exists("q", $queryParams)) {
            return $response->withAddedHeader("Location", "/");
        }

        switch ($queryParams["q"]) {
            case "test":
                return $response->withAddedHeader("Location", "/linktree");
                break;
        }


        return $response->withStatus(307);
    }
}