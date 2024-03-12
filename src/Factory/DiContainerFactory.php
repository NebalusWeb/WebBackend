<?php

namespace Nebalus\Ownsite\Factory;

use DI\Container;
use DI\ContainerBuilder;
use Exception;
use PDO;
use Slim\Views\Twig;
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
            Twig::class => factory([TwigFactory::class, 'build'])
        ];

        $builder = new ContainerBuilder();
        $builder->useAutowiring(true);
        $builder->addDefinitions($appDefinitions);

        return $builder->build();
    }
}
