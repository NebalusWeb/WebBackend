<?php

namespace Nebalus\Webapi\Utils\Sanitizr\Schema;

class ObjectSchema extends AbstractSchema
{

    public function __construct(private array $schema)
    {
    }

    private Sche $schemas;

    protected function parseValue($value): mixed
    {
        // TODO: Implement parseValue() method.
    }
}
