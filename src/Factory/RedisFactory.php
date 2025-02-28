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
        $options = [
            'readTimeout' => 2.5,
            'connectTimeout' => 2.5,
            'persistent' => false,
            'retryInterval' => 5,
        ];
        $redis = new Redis($options);
        $redis->connect($this->envData->getRedisHost(), $this->envData->getRedisPort());

        return $redis;
    }
}
