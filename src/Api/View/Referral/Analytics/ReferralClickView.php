<?php

namespace Nebalus\Webapi\Api\View\Referral\Analytics;

use Nebalus\Webapi\Value\Referral\Referral;
use Nebalus\Webapi\Value\Result\Result;
use Nebalus\Webapi\Value\Result\ResultInterface;

class ReferralClickView
{
    public static function render(Referral $referral): ResultInterface
    {
        $fields = [
            "pointer" => $referral->getPointer()
        ];

        return Result::createSuccess("Referral found", 200, $fields);
    }
}
