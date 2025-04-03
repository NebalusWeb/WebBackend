<?php

namespace Nebalus\Webapi\Api\Module\Referral\Delete;

use Fig\Http\Message\StatusCodeInterface;
use Nebalus\Webapi\Value\Internal\Result\Result;
use Nebalus\Webapi\Value\Internal\Result\ResultInterface;

class DeleteReferralView
{
    public function render(): ResultInterface
    {
        return Result::createSuccess("Referral deleted", StatusCodeInterface::STATUS_OK);
    }
}
