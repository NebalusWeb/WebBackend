<?php

namespace Nebalus\Webapi\Api\Service\Linktree;

use Nebalus\Webapi\Api\View\Linktree\LinktreeCreateView;
use Nebalus\Webapi\Value\Result\ResultInterface;

readonly class LinktreeCreateService
{
    public function __construct(
    ) {
    }

    public function execute(array $params): ResultInterface
    {
        return LinktreeCreateView::render();
    }
}
