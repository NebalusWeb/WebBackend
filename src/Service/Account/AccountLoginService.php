<?php

namespace Nebalus\Webapi\Service\Account;

use Nebalus\Webapi\Repository\MySqlReferralRepository;

class AccountLoginService
{
    private MySqlReferralRepository $mySqlRepository;
    public function __construct(
        MySqlReferralRepository $mySqlRepository,
    ) {
        $this->mySqlRepository = $mySqlRepository;
    }

    public function action()
    {
        $this->mySqlRepository->getAccountFromId(1);
    }
}
