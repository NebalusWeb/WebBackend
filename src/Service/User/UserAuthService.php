<?php

namespace Nebalus\Webapi\Service\User;

use Nebalus\Webapi\Repository\MySqlAccountRepository;
use Nebalus\Webapi\Repository\MySqlReferralRepository;

class UserAuthService
{
    private MySqlAccountRepository $mySqlAccountRepository;
    public function __construct(
        MySqlAccountRepository $mySqlAccountRepository,
    ) {
        $this->mySqlAccountRepository = $mySqlAccountRepository;
    }

    public function action()
    {
        $this->mySqlAccountRepository->getAccountFromId(1);
    }
}
