<?php

declare(strict_types=1);

namespace Nebalus\Webapi\Option;

use Monolog\Level;

class EnvData
{
    private bool $isProduction;
    private bool $isDevelopment;
    private Level $logLevel;
    private string $jwtSecret;
    private string $mysqlPasswd;
    private string $mysqlHost;
    private string $mysqlPort;
    private string $mysqlDatabase;
    private string $mysqlUser;
    private string $accessControlAllowOrigin;
    private int $jwtNormalExpirationTime;
    private int $jwtExtendedExpirationTime;
    private string $passwdHashKey;

    public function __construct()
    {
        $this->isProduction = strtolower(getenv("APP_ENV")) === "production";
        $this->isDevelopment = strtolower(getenv("APP_ENV")) === "development";
        $this->logLevel = Level::fromName(getenv("ERROR_LOGLEVEL"));
        $this->jwtSecret = getenv("JWT_SECRET");
        $this->jwtNormalExpirationTime = (int) getenv('JWT_NORMAL_EXPIRATION_TIME');
        $this->jwtExtendedExpirationTime = (int) getenv('JWT_EXTENDED_EXPIRATION_TIME');
        $this->mysqlPasswd = getenv("MYSQL_PASSWORD");
        $this->mysqlHost = getenv("MYSQL_HOST");
        $this->mysqlPort = getenv("MYSQL_PORT");
        $this->mysqlDatabase = getenv("MYSQL_DATABASE");
        $this->mysqlUser = getenv("MYSQL_USER");
        $this->passwdHashKey = getenv('PASSWD_HASH_KEY');
        $this->accessControlAllowOrigin = getenv("ACCESS_CONTROL_ALLOW_ORIGIN");
    }

    public function isProduction(): bool
    {
        return $this->isProduction;
    }

    public function isDevelopment(): bool
    {
        return $this->isDevelopment;
    }

    public function getLogLevel(): Level
    {
        return $this->logLevel;
    }

    public function getJwtSecret(): string
    {
        return $this->jwtSecret;
    }

    public function getMySqlPasswd(): string
    {
        return $this->mysqlPasswd;
    }

    public function getMySqlHost(): string
    {
        return $this->mysqlHost;
    }

    public function getMySqlPort(): string
    {
        return $this->mysqlPort;
    }


    public function getMySqlDatabase(): string
    {
        return $this->mysqlDatabase;
    }

    public function getMySqlUser(): string
    {
        return $this->mysqlUser;
    }

    public function getJwtNormalExpirationTime(): int
    {
        return $this->jwtNormalExpirationTime;
    }

    public function getJwtExtendedExpirationTime(): int
    {
        return $this->jwtExtendedExpirationTime;
    }

    public function getPasswdHashKey(): string
    {
        return $this->passwdHashKey;
    }
    public function getAccessControlAllowOrigin(): string
    {
        return $this->accessControlAllowOrigin;
    }
}
