<?php

namespace TestApi\Factory;

use DI\Container;
use DI\ContainerBuilder;
use Exception;

class DiContainerFactory
{

    /**
     * @throws Exception
     */
    public function build(): Container
    {
        $appDefinitions = [];

        $builder = new ContainerBuilder();
        $builder->useAutowiring(true);
        $builder->addDefinitions($appDefinitions);

        return $builder->build();
    }

}