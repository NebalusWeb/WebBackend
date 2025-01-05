<?php

namespace Nebalus\Webapi\Utils\Sanitizr;

use Nebalus\Webapi\Utils\Sanitizr\Schema\AbstractSanitizerSchema;
use Nebalus\Webapi\Utils\Sanitizr\Schema\SanitizerArraySchema;
use Nebalus\Webapi\Utils\Sanitizr\Schema\SanitizerBooleanSchema;
use Nebalus\Webapi\Utils\Sanitizr\Schema\SanitizerFloatSchema;
use Nebalus\Webapi\Utils\Sanitizr\Schema\SanitizerIntegerSchema;
use Nebalus\Webapi\Utils\Sanitizr\Schema\SanitizerObjectSchema;
use Nebalus\Webapi\Utils\Sanitizr\Schema\SanitizerStringSchema;

class Sanitizr
{
    public static function boolean(): SanitizerBooleanSchema
    {
        return new SanitizerBooleanSchema();
    }

    public static function integer(): SanitizerIntegerSchema
    {
        return new SanitizerIntegerSchema();
    }

    public static function float(): SanitizerFloatSchema
    {
        return new SanitizerFloatSchema();
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

//    public static function null()
//    {
//
//    }
}
