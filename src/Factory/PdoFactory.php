<?php

namespace Nebalus\Ownsite\Factory;

use PDO;

class PdoFactory
{

    public function build(): PDO
    {
        $dsn = 'mysql:host=mysql-db:3306;dbname=main';
        
        return new PDO($dsn, getenv("MYSQL_USER"), getenv("MYSQL_PASSWORD"));
    }

}