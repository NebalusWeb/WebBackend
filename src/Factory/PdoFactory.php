<?php

namespace Nebalus\Webapi\Factory;

use PDO;

class PdoFactory
{
    public function build(): PDO
    {
        $dsn = 'mysql:host=mysql:3306;dbname=main';

        return new PDO($dsn, getenv("MYSQL_USER"), getenv("MYSQL_PASSWORD"));
    }
}
