<?php

namespace Nebalus\Webapi\Api\Referral\Analytics\ClickHistory;

use Nebalus\Webapi\Value\Result\Result;
use Nebalus\Webapi\Value\Result\ResultInterface;

class ClickHistoryReferralView
{
    public static function render(): ResultInterface
    {
        $fields = [];

        return Result::createSuccess("Referral history found", 200, $fields);
    }
}
