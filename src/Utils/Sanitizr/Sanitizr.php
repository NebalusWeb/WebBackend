<?php

namespace Nebalus\Webapi\Utils\Sanitizr;

use Nebalus\Webapi\Utils\Sanitizr\Schema\ArraySchema;
use Nebalus\Webapi\Utils\Sanitizr\Schema\BooleanSchema;
use Nebalus\Webapi\Utils\Sanitizr\Schema\FloatSchema;
use Nebalus\Webapi\Utils\Sanitizr\Schema\IntegerSchema;
use Nebalus\Webapi\Utils\Sanitizr\Schema\ObjectSchema;
use Nebalus\Webapi\Utils\Sanitizr\Schema\StringSchema;

class Sanitizr
{
    public static function boolean()
    {
        return new BooleanSchema();
    }
    public static function integer()
    {
        return new IntegerSchema();
    }
    public static function float()
    {
        return new FloatSchema();
    }
    public static function string()
    {
        return new StringSchema();
    }
    public static function array()
    {
        return new ArraySchema();
    }
    public static function object()
    {
        return new ObjectSchema();
    }
}
