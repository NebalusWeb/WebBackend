<?php

namespace Nebalus\Webapi\Factory;

use Monolog\Formatter\JsonFormatter;
use Monolog\Handler\StreamHandler;
use Monolog\Level;
use Monolog\Logger;
use Nebalus\Webapi\Option\EnvData;

class LoggerFactory
{
    private EnvData $env;
    public function __construct(EnvData $env)
    {
        $this->env = $env;
    }

    public function build(): Logger
    {
        $errorLogStream = new StreamHandler(__DIR__ . '/../../logs/error.log', $this->env->getLogLevel());
        $errorLogStream->setFormatter(new JsonFormatter());

        $logger = new Logger("ErrorLogger");
        $logger->pushHandler($errorLogStream);

        return $logger;
    }
}
