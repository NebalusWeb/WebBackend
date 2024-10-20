<?php

declare(strict_types=1);

namespace Nebalus\Webapi\View\Referral;

use Nebalus\Webapi\ValueObject\ApiResponse\ApiResponse;
use Nebalus\Webapi\ValueObject\ApiResponse\ApiResponseInterface;
use Nebalus\Webapi\ValueObject\Referral\Referral;

class ReferralView
{
    public function render(Referral $referral, bool $safeMode = true): ApiResponseInterface
    {
        $payload = [
            "code" => $referral->getCode(),
            "pointer" => $referral->getPointer(),
            "view_count" => $referral->getViewCount(),
            "creation_date_timestamp" => $referral->getCreationDate()->getTimestamp(),
            "enabled" => $referral->isEnabled()
        ];

        if ($safeMode === false) {
            $payload["referral_id"] = $referral->getReferralId();
            $payload["owner_id"] = $referral->getUserId()->asInt();
        }

        return ApiResponse::createSuccess($payload, 200);
    }
}
