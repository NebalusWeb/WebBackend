<?php

namespace Nebalus\Webapi\Api\Referral\Analytics\Click;

use Nebalus\Webapi\Value\Referral\Referral;
use Nebalus\Webapi\Value\Result\Result;
use Nebalus\Webapi\Value\Result\ResultInterface;

class ClickReferralView
{
    public static function render(Referral $referral): ResultInterface
    {
        $fields = [
            "pointer" => $referral->getPointer()
        ];

        return Result::createSuccess("Referral found", 200, $fields);
    }
}
