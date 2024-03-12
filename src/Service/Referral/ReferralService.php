<?php

namespace Nebalus\Ownsite\Service\Referral;

use Nebalus\Ownsite\Repository\MysqlRepository;
use Nebalus\Ownsite\ValueObject\MysqlRepositoryResponse;

class ReferralService
{
    private MysqlRepository $mysqlRepository;

    public function __construct(MysqlRepository $mysqlRepository)
    {
        $this->mysqlRepository = $mysqlRepository;
    }

    public function execute()
    {
        $this->mysqlRepository->getReferralByCode("TEST");
    }
}
