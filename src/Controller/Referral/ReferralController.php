<?php

namespace Nebalus\Ownsite\Controller\Referral;

use Nebalus\Ownsite\Service\Referral\ReferralService;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class ReferralController
{

    private ReferralService $referralService;

    public function __construct(ReferralService $referralService)
    {
        $this->referralService = $referralService;
    }

    public function action(Request $request, Response $response, array $args): Response
    {
        $queryParams = $request->getQueryParams();
        $response = $response->withStatus(307);
        if(!key_exists("q", $queryParams)) {
            return $response->withAddedHeader("Location", "/");
        }

        $this->referralService->execute();
        return $response;
    }
}