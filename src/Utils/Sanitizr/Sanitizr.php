<?php

namespace Nebalus\Webapi\Utils\Sanitizr;

use Nebalus\Webapi\Utils\Sanitizr\Schema\AbstractSanitizerSchema;
use Nebalus\Webapi\Utils\Sanitizr\Schema\SanitizerArraySchema;
use Nebalus\Webapi\Utils\Sanitizr\Schema\SanitizerBooleanSchema;
use Nebalus\Webapi\Utils\Sanitizr\Schema\SanitizerNullSchema;
use Nebalus\Webapi\Utils\Sanitizr\Schema\SanitizerNumberSchema;
use Nebalus\Webapi\Utils\Sanitizr\Schema\SanitizerObjectSchema;
use Nebalus\Webapi\Utils\Sanitizr\Schema\SanitizerStringSchema;

class Sanitizr
{
    public static function boolean(): SanitizerBooleanSchema
    {
        return new SanitizerBooleanSchema();
    }

    public static function number(): SanitizerNumberSchema
    {
        return new SanitizerNumberSchema();
    }

    public static function string(): SanitizerStringSchema
    {
        return new SanitizerStringSchema();
    }

    public static function array(AbstractSanitizerSchema $schema): SanitizerArraySchema
    {
        return new SanitizerArraySchema($schema);
    }

    public static function object(array $schemas): SanitizerObjectSchema
    {
        return new SanitizerObjectSchema($schemas);
    }

    public static function null(): SanitizerNullSchema
    {
        return new SanitizerNullSchema();
    }
}
