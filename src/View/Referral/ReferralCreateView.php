<?php

declare(strict_types=1);

namespace Nebalus\Webapi\View\Referral;

use Nebalus\Webapi\ValueObject\ApiResponse\ApiResponse;
use Nebalus\Webapi\ValueObject\ApiResponse\ApiResponseInterface;
use Nebalus\Webapi\ValueObject\Referral\Referral;

class ReferralCreateView
{
    public function render(Referral $referral, bool $safeMode = true): ApiResponseInterface
    {
        $payload = [
            "referral" => [
                "code" => $referral->getCode(),
                "pointer" => $referral->getPointer(),
                "view_count" => $referral->getViewCount(),
                "creation_date_timestamp" => $referral->getCreationDate()->getTimestamp(),
                "enabled" => $referral->isEnabled()
            ]
        ];

        if ($safeMode === false) {
            $payload["referral"]["referral_id"] = $referral->getReferralId();
            $payload["referral"]["owner_id"] = $referral->getUserId()->asInt();
        }

        return ApiResponse::createSuccess($payload, 200);
    }
}
