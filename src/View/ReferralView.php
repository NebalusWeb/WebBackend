<?php

declare(strict_types=1);

namespace Nebalus\Webapi\View;

use Nebalus\Webapi\ValueObject\ApiResponse\ApiResponseInterface;
use Nebalus\Webapi\ValueObject\ApiResponse\ApiSuccessResponse;
use Nebalus\Webapi\ValueObject\Referral\Referral;

class ReferralView
{
    public function render(Referral $referral, bool $safeMode = true): ApiResponseInterface
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
            $payload["owner_id"] = $referral->getDbUserId();
        }

        return ApiSuccessResponse::from($payload, 200);
    }
}
