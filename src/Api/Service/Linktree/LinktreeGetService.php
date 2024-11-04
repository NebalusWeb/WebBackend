<?php

namespace Nebalus\Webapi\Api\Service\Linktree;

use Nebalus\Webapi\Api\View\Linktree\LinktreeGetView;
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
