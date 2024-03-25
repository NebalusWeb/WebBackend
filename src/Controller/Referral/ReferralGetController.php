<?php

namespace Nebalus\Webapi\Controller\Referral;

use InvalidArgumentException;
use Nebalus\Webapi\Controller\BaseController;
use Nebalus\Webapi\Exception\ApiException;
use Nebalus\Webapi\Service\Referral\ReferralGetService;
use Nebalus\Webapi\ValueObject\JsonResponse;
use Nebalus\Webapi\View\ReferralView;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class ReferralGetController extends BaseController
{
    private ReferralGetService $referralGetService;
    private ReferralView $referralView;

    public function __construct(
        JsonResponse $jsonResponse,
        ReferralGetService $referralGetService,
        ReferralView $referralView
    ) {
        parent::__construct($jsonResponse);

        $this->referralGetService = $referralGetService;
        $this->referralView = $referralView;
    }

    public function action(Request $request, Response $response, array $args): Response
    {
        // Gets Params
        if (array_key_exists("code", $args)) {
            $code = $args["code"];
        } else {
            return $this->failedAction($response, "There is no code to process");
        }

        try {
            $referral = $this->referralGetService->action($code);
        } catch (ApiException $e) {
            return $this->failedAction($response, $e->getMessage(), $e->getCode());
        }

        $this->jsonResponse->setStatus(0);
        $this->jsonResponse->setData($this->referralView->referralToArray($referral));

        $response->getBody()->write($this->jsonResponse->format());
        return $response->withStatus(200);
    }
}
