<?php

declare(strict_types=1);

namespace Nebalus\Webapi\Factory;

use DI\Container;
use DI\ContainerBuilder;
use Exception;
use Nebalus\Webapi\ApplicationConfig;

class DiContainerFactory
{
    /**
     * @throws Exception
     */
    public function build(): Container
    {
        $builder = new ContainerBuilder();
        $builder->useAutowiring(true);
        $builder->addDefinitions(new ApplicationConfig());

        return $builder->build();
    }
}
