<?php

declare(strict_types=1);

namespace Nebalus\Webapi\Factory;

use DI\Container;
use DI\ContainerBuilder;
use Exception;
use Monolog\Logger;
use PDO;
use Psr\Http\Message\ResponseFactoryInterface;

use function DI\factory;

class DiContainerFactory
{
    /**
     * @throws Exception
     */
    public function build(): Container
    {
        $appDefinitions = [
            PDO::class => factory([PdoFactory::class, 'build']),
            Logger::class => factory([LoggerFactory::class, "build"]),
            ResponseFactoryInterface::class => new ResponseFactory()
        ];

        $builder = new ContainerBuilder();
        $builder->useAutowiring(true);
        $builder->addDefinitions($appDefinitions);

        return $builder->build();
    }
}
