<?php

namespace Nebalus\Webapi\Service\Referral;

use Nebalus\Webapi\Repository\MysqlRepository;

class ReferralService
{
    private MysqlRepository $mysqlRepository;

    public function __construct(MysqlRepository $mysqlRepository)
    {
        $this->mysqlRepository = $mysqlRepository;
    }

    public function execute(): void
    {
        $this->mysqlRepository->getReferralByCode("TEST");
    }
}
