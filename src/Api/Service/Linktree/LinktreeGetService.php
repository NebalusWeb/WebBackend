<?php

namespace Nebalus\Webapi\Api\Service\Referral;

use Nebalus\Webapi\Api\View\Referral\LinktreeGetView;
use Nebalus\Webapi\Value\Result\ResultInterface;

readonly class LinktreeGetService
{
    public function __construct(
    ) {
    }

    public function execute(array $params): ResultInterface
    {
        return LinktreeGetView::render();
    }
}
