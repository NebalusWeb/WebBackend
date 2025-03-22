<?php

declare(strict_types=1);

namespace Nebalus\Webapi\Factory;

use Monolog\Formatter\LineFormatter;
use Monolog\Formatter\NormalizerFormatter;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Nebalus\Webapi\Config\GeneralConfig;

readonly class LoggerFactory
{
    public function __construct(
        private GeneralConfig $env
    ) {
    }
    public function __invoke(): Logger
    {
        $format = "%datetime% | %level_name% | %message% | %context%\n";
        $formatter = new LineFormatter($format, NormalizerFormatter::SIMPLE_DATE);

        $errorLogStream = new StreamHandler(__DIR__ . '/../../logs/error.log', $this->env->getLogLevel());
        $errorLogStream->setFormatter($formatter);

        $logger = new Logger("ErrorLogger");
        $logger->pushHandler($errorLogStream);

        return $logger;
    }
}
