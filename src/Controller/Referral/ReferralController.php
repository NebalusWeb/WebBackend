<?php

namespace Nebalus\Ownsite\Controller\Referral;

use Nebalus\Ownsite\Service\ReferralService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class ReferralController
{

    private ReferralService $referralService;

    public function __construct(ReferralService $referralService)
    {
        $this->referralService = $referralService;
    }

    public function referral(Request $request, Response $response): Response
    {
        $queryParams = $request->getQueryParams();
        $response = $response->withStatus(307);
        if(!key_exists("q", $queryParams)) {
            return $response->withAddedHeader("Location", "/");
        }

        $this->referralService->execute();

        switch ($queryParams["q"]) {
            case "test":
                return $response->withAddedHeader("Location", "/linktree");
                break;
        }


        return $response->withStatus(307);
    }
}