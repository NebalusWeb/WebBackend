<?php

namespace Nebalus\Webapi\Api\Module\Linktree\Delete;

use Nebalus\Webapi\Value\Internal\Result\ResultInterface;

readonly class DeleteLinktreeService
{
    public function __construct(
        private DeleteLinktreeView $view,
    ) {
    }

    public function execute(DeleteLinktreeValidator $validator): ResultInterface
    {
        return $this->view->render();
    }
}
