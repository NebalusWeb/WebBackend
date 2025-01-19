<?php

namespace Nebalus\Webapi\Factory;

use Nebalus\Webapi\Option\EnvData;
use Redis;

readonly class RedisFactory
{
    public function __construct(
        private EnvData $envData
    ) {
    }

    public function __invoke(): Redis
    {
        $redis = new Redis();
        $redis->connect($this->envData->getRedisHost(), $this->envData->getRedisPort());

        return $redis;
    }
}
