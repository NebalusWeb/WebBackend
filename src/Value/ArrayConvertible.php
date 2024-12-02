<?php

namespace Nebalus\Webapi\Value;

interface ArrayConvertible
{
    public function toArray(): array;

    public static function fromArray(array $data): self;
}
