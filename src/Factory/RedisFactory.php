<?php

namespace Nebalus\Webapi\Factory;

use Redis;

class RedisFactory
{
    public function __construct()
    {
    }

    public function build(): Redis
    {
        $host = "127.0.0.1";
        $port = "6379";

        $redis = new Redis();
        $redis->connect($host, $port);

        return $redis;
    }
}
