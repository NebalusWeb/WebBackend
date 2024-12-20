<?php

namespace Nebalus\Webapi\Api\Module\Referral\Delete;

use Nebalus\Webapi\Value\Result\Result;
use Nebalus\Webapi\Value\Result\ResultInterface;

class DeleteReferralView
{
    public static function render(): ResultInterface
    {
        return Result::createSuccess("Referral deleted", 200);
    }
}
