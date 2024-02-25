<?php

namespace Nebalus\Ownsite\Repository;

use Nebalus\Ownsite\ValueObject\MysqlRepositoryResponse;

class MysqlRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function createReferral(): MysqlRepositoryResponse
    {

    }

    public function deleteReferral(): MysqlRepositoryResponse
    {

    }

    public function updateReferral(): MysqlRepositoryResponse
    {

    }

    public function getReferral(): MysqlRepositoryResponse
    {

    }
}