<?php

declare(strict_types=1);

namespace Nebalus\Webapi\View\Referral;

use Nebalus\Webapi\ValueObject\ApiResponse\ApiResponse;
use Nebalus\Webapi\ValueObject\ApiResponse\ApiResponseInterface;
use Nebalus\Webapi\ValueObject\Referral\Referral;

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
