<?php

declare(strict_types=1);

namespace Nebalus\Webapi\Factory;

use Nebalus\Webapi\Option\EnvData;
use PDO;
use PDOException;

class PdoFactory
{
    public function __construct(
        private EnvData $env
    ) {
    }

    /**
     * @throws PDOException
     */
    public function build(): Pdo
    {
        $host = $this->env->getMySqlHost();
        $port = $this->env->getMySqlPort();
        $database = $this->env->getMySqlDatabase();
        $username = $this->env->getMySqlUser();
        $password = $this->env->getMySqlPasswd();

        $dsn = sprintf('mysql:host=%s;port=%s;dbname=%s', $host, $port, $database);
        $pdo = new PDO($dsn, $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $pdo->setAttribute(PDO::ATTR_STRINGIFY_FETCHES, false);
        return $pdo;
    }
}
