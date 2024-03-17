<?php

namespace Nebalus\Webapi\Controller\Referral;

use Nebalus\Webapi\ValueObjects\HttpBodyJsonResponse;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class ReferralApiGetController
{
    private HttpBodyJsonResponse $httpBodyJsonResponse;

    public function __construct(HttpBodyJsonResponse $httpBodyJsonResponse)
    {
        $this->httpBodyJsonResponse = $httpBodyJsonResponse;
    }

    public function action(Request $request, Response $response, array $args): Response
    {
        $queryParams = $request->getQueryParams();
        $requestedPointer = array_key_exists("pointer", $queryParams) ? $queryParams["pointer"] : null;

        $response = $response->withStatus(200);

        // Default
        $this->httpBodyJsonResponse->setSuccess(true);
        $this->httpBodyJsonResponse->setStatusCode($response->getStatusCode());

        $response->getBody()->write($this->httpBodyJsonResponse->format());

        return $response;
    }
}
