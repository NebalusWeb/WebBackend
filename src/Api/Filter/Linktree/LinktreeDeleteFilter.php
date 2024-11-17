<?php

namespace Nebalus\Webapi\Api\Filter\Linktree;

use Nebalus\Webapi\Api\Filter\AbstractFilter;
use Override;

class LinktreeDeleteFilter extends AbstractFilter
{
    #[Override] public function filterAndCheckIfStructureIsValid(array $params): bool
    {
        $requiredParams = [];
        if ($this->checkIfAnyRequiredParamsAreMissing($requiredParams, $params)) {
            return false;
        }

        $this->filteredData = [];

        return true;
    }
}
