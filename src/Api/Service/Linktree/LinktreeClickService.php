<?php

namespace Nebalus\Webapi\Api\Service\Referral;

use Nebalus\Webapi\Api\View\Referral\LinktreeClickView;
use Nebalus\Webapi\Value\Result\ResultInterface;

readonly class LinktreeClickService
{
    public function __construct(
    ) {
    }

    public function execute(array $params): ResultInterface
    {
        return LinktreeClickView::render();
    }
}
