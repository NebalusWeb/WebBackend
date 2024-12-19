<?php

namespace Nebalus\Webapi\Api\Linktree\Delete;

use Nebalus\Webapi\Value\Result\ResultInterface;

readonly class DeleteLinktreeService
{
    public function __construct(
    ) {
    }

    public function execute(array $params): ResultInterface
    {
        return DeleteLinktreeView::render();
    }
}
