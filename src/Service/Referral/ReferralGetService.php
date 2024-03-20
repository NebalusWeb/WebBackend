<?php

namespace Nebalus\Webapi\Service\Referral;

use Nebalus\Webapi\Repository\MySqlRepository;

class ReferralGetService
{
    private MySqlRepository $mySqlRepository;
    public function __construct(
        MySqlRepository $mySqlRepository,
    ) {
        $this->mySqlRepository = $mySqlRepository;
    }

    public function action()
    {
        $this->mySqlRepository->getAccountFromId(1);
    }
}
