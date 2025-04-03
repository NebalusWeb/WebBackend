<?php

namespace Nebalus\Webapi\Api\Module\Linktree\Get;

use Nebalus\Webapi\Value\Internal\Result\ResultInterface;

readonly class GetLinktreeService
{
    public function __construct(
        private GetLinktreeView $view,
    ) {
    }

    public function execute(GetLinktreeValidator $validator): ResultInterface
    {
        return $this->view->render();
    }
}
