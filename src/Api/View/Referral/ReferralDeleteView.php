<?php

namespace Nebalus\Webapi\Api\View\Referral;

use Nebalus\Webapi\Value\Result\Result;
use Nebalus\Webapi\Value\Result\ResultInterface;

class ReferralDeleteView
{
    public static function render(): ResultInterface
    {
        return Result::createSuccess("Referral deleted", 200);
    }
}
