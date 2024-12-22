<?php

namespace Nebalus\Webapi\Repository;

use PDO;

abstract class AbstractRepository
{
    public function __construct(private PDO $pdo)
    {
    }

    public function startTransaction(): bool
    {
        return $this->pdo->beginTransaction();
    }

    public function rollbackTransaction(): bool
    {
        return $this->pdo->rollBack();
    }

    public function commitTransaction(): bool
    {
        return $this->pdo->commit();
    }
}
