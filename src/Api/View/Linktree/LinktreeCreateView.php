<?php

namespace Nebalus\Webapi\Api\View\Referral;

use Nebalus\Webapi\Value\Referral\Referral;
use Nebalus\Webapi\Value\Result\Result;
use Nebalus\Webapi\Value\Result\ResultInterface;

class LinktreeCreateView
{
    public static function render(): ResultInterface
    {
        $fields = [];

        return Result::createSuccess("PLACEHOLDER", 200, $fields);
    }
}
