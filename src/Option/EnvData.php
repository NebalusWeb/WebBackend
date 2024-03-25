<?php

namespace Nebalus\Webapi\Option;

class EnvData
{
    private bool $isProduction;
    private bool $isDevelopment;
    private string $jwtSecret;

    public function __construct()
    {
        $this->isProduction = strtolower(getenv("APP_ENV")) === "production";
        $this->isDevelopment = strtolower(getenv("APP_ENV")) === "development";
        $this->jwtSecret = getenv("JWT_SECRET");
    }

    public function isProduction()
    {
        return $this->isProduction;
    }

    public function isDevelopment()
    {
        return $this->isDevelopment;
    }

    public function getJwtSecret(): string
    {
        return $this->jwtSecret;
    }
}
