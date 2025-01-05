<?php

namespace Nebalus\Webapi\Utils\Sanitizr;

use Nebalus\Webapi\Utils\Sanitizr\Schema\AbstractSchema;
use Nebalus\Webapi\Utils\Sanitizr\Schema\ArraySchema;
use Nebalus\Webapi\Utils\Sanitizr\Schema\BooleanSchema;
use Nebalus\Webapi\Utils\Sanitizr\Schema\FloatSchema;
use Nebalus\Webapi\Utils\Sanitizr\Schema\IntegerSchema;
use Nebalus\Webapi\Utils\Sanitizr\Schema\ObjectSchema;
use Nebalus\Webapi\Utils\Sanitizr\Schema\StringSchema;

class Sanitizr
{
    public static function boolean(): BooleanSchema
    {
        return new BooleanSchema();
    }

    public static function integer(): IntegerSchema
    {
        return new IntegerSchema();
    }

    public static function float(): FloatSchema
    {
        return new FloatSchema();
    }

    public static function string(): StringSchema
    {
        return new StringSchema();
    }

    public static function array(AbstractSchema $schema): ArraySchema
    {
        return new ArraySchema($schema);
    }

    public static function object(array $schemas): ObjectSchema
    {
        return new ObjectSchema($schemas);
    }
}
