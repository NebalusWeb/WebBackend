<?php

namespace Nebalus\Webapi\Controller\Referral;

use InvalidArgumentException;
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
        $requestedPointer = array_key_exists("pointer", $queryParams) ? $queryParams["pointer"] : throw new InvalidArgumentException("No 'pointer' set in query params", 400);

        // Default
        $this->httpBodyJsonResponse->setStatusCode($response->getStatusCode());

        $response->getBody()->write($this->httpBodyJsonResponse->format());

        return $response->withStatus(200);
    }
}
