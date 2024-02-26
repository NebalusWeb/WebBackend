<?php

namespace Nebalus\Ownsite\Repository;

use Nebalus\Ownsite\ValueObject\MysqlRepositoryResponse;
use PDO;

class MysqlRepository
{
    private PDO $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function createReferral(string $code, string $pointer): MysqlRepositoryResponse
    {

    }

    public function deleteReferralById(int $id): MysqlRepositoryResponse
    {

    }

    public function deleteReferralByCode(string $code): MysqlRepositoryResponse
    {

    }

    public function updateReferral(): MysqlRepositoryResponse
    {

    }

    public function getReferralById(int $id): MysqlRepositoryResponse
    {

    }

    public function getReferralByCode(string $code): MysqlRepositoryResponse
    {

    }
}