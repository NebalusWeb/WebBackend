<?php

namespace Nebalus\Webapi\Filter;

interface FilterInterface
{
    public function getErrorMessage(): string;

    public function getFilteredData(): array;
}
