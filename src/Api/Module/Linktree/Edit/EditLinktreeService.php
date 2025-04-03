<?php

namespace Nebalus\Webapi\Api\Module\Linktree\Edit;

use Nebalus\Webapi\Api\Module\Referral\Edit\EditReferralView;
use Nebalus\Webapi\Value\Internal\Result\ResultInterface;

readonly class EditLinktreeService
{
    public function __construct(
        private EditLinktreeView $view,
    ) {
    }

    public function execute(EditLinktreeValidator $validator): ResultInterface
    {
        return $this->view->render();
    }
}
