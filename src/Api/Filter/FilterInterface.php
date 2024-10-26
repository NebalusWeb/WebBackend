<?php

namespace Nebalus\Webapi\Api\Filter;

interface FilterInterface
{
    public function getErrorMessage(): string;

    public function getFilteredData(): array;
}
