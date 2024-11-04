<?php

namespace Nebalus\Webapi\Api\Service\Referral;

use Nebalus\Webapi\Api\View\Referral\LinktreeEditView;
use Nebalus\Webapi\Value\Result\ResultInterface;

readonly class LinktreeEditService
{
    public function __construct(
    ) {
    }

    public function execute(array $params): ResultInterface
    {
        return LinktreeEditView::render();
    }
}
