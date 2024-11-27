<?php

namespace Nebalus\Webapi\Factory;

use Nebalus\Webapi\Option\EnvData;
use Redis;

class RedisFactory
{
    public function __construct(
        private readonly EnvData $envData
    ) {
    }

    public function __invoke(): Redis
    {
        $redis = new Redis();
        $redis->connect($this->envData->getRedisHost(), $this->envData->getRedisPort());

        return $redis;
    }
}
