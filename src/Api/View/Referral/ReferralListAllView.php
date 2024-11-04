<?php

namespace Nebalus\Webapi\Api\View\Referral;

use Nebalus\Webapi\Value\Referral\Referrals;
use Nebalus\Webapi\Value\Result\Result;
use Nebalus\Webapi\Value\Result\ResultInterface;

class ReferralListAllView
{
    public static function render(Referrals $referrals): ResultInterface
    {

        $fields = [

        ];

        return Result::createSuccess("PLACEHOLDER", 200, $fields);
    }
}
