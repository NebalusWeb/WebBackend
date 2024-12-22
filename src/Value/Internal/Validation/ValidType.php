<?php

namespace Nebalus\Webapi\Value\Internal\Validation;

enum ValidType
{
    case STRING;
    case OBJECT;
    case FLOAT;
    case ARRAY;
    case INTEGER;
    case BOOLEAN;
}
