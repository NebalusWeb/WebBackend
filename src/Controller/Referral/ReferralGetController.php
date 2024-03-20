<?php

namespace Nebalus\Webapi\Controller\Referral;

use InvalidArgumentException;
use Nebalus\Webapi\Service\Referral\ReferralGetService;
use Nebalus\Webapi\ValueObjects\HttpBodyJsonResponse;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class ReferralGetController
{
    private HttpBodyJsonResponse $httpBodyJsonResponse;
    private ReferralGetService $referralGetService;

    public function __construct(HttpBodyJsonResponse $httpBodyJsonResponse, ReferralGetService $referralGetService)
    {
        $this->httpBodyJsonResponse = $httpBodyJsonResponse;
        $this->referralGetService = $referralGetService;
    }

    public function action(Request $request, Response $response, array $args): Response
    {
        $queryParams = $request->getQueryParams();
        $requestedPointer = array_key_exists("pointer", $queryParams) ? $queryParams["pointer"] : throw new InvalidArgumentException("No 'pointer' set in query params", 400);

        $this->referralGetService->action();

        // Default
        $this->httpBodyJsonResponse->setStatus(0);

        $response->getBody()->write($this->httpBodyJsonResponse->format());

        return $response->withStatus(200);
    }
}
