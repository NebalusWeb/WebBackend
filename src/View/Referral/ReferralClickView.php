<?php

declare(strict_types=1);

namespace Nebalus\Webapi\View\Referral;

use Nebalus\Webapi\Value\ApiResponse\ApiResponse;
use Nebalus\Webapi\Value\ApiResponse\ApiResponseInterface;
use Nebalus\Webapi\Value\Referral\Referral;

class ReferralClickView
{
    public function render(Referral $referral): ApiResponseInterface
    {
        $payload = [
            "referral" => [
                "pointer" => $referral->getPointer()
            ]
        ];

        return ApiResponse::createSuccess($payload, 200);
    }
}
