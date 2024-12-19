<?php

namespace Nebalus\Webapi\Api\Linktree\Service;

use Nebalus\Webapi\Api\Linktree\View\LinktreeCreateView;
use Nebalus\Webapi\Value\Result\ResultInterface;

readonly class LinktreeCreateService
{
    public function __construct()
    {
    }

    public function execute(array $params): ResultInterface
    {
        return LinktreeCreateView::render();
    }
}
