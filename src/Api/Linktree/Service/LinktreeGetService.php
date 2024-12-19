<?php

namespace Nebalus\Webapi\Api\Linktree\Service;

use Nebalus\Webapi\Api\Linktree\View\LinktreeGetView;
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
