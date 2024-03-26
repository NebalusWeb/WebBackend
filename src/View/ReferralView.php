<?php

namespace Nebalus\Webapi\View;

use Nebalus\Webapi\ValueObject\Referral\ReferralObject;

class ReferralView
{
    public function referralToArray(ReferralObject $referral, bool $safemode = true): array
    {
        $view = [
            "code" => $referral->getCode(),
            "pointer" => $referral->getPointer(),
            "viewcount" => $referral->getViewCount(),
            "creation_timestamp" => $referral->getCreationDate()->getTimestamp(),
            "enabled" => $referral->isEnabled()
        ];

        if ($safemode === false) {
            $view["id"] = $referral->getDbId();
            $view["owner_id"] = $referral->getDbAccountId();
        }

        return $view;
    }
}
