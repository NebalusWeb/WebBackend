<?php

namespace Nebalus\Webapi\Factory;

use Monolog\Handler\StreamHandler;
use Monolog\Level;
use Monolog\Logger;

class LoggerFactory
{
    public function build(): Logger
    {
        return new Logger("DefaultLogger");
    }
}
