<?php

namespace Nebalus\Webapi\View;

use Nebalus\Webapi\ValueObject\ApiResponse\ApiResponseInterface;
use Nebalus\Webapi\ValueObject\ApiResponse\ApiSuccessResponse;
use Nebalus\Webapi\ValueObject\Referral\ReferralObject;

class ReferralView
{
    public function render(ReferralObject $referral, bool $safeMode = true): ApiResponseInterface
    {
        $payload = [
            "code" => $referral->getCode(),
            "pointer" => $referral->getPointer(),
            "view_count" => $referral->getViewCount(),
            "creation_timestamp" => $referral->getCreationDate()->getTimestamp(),
            "enabled" => $referral->isEnabled()
        ];

        if ($safeMode === false) {
            $payload["id"] = $referral->getDbId();
            $payload["owner_id"] = $referral->getDbAccountId();
        }

        return ApiSuccessResponse::from($payload, 200);
    }
}
