<?php

namespace Nebalus\Webapi\Service\User;

use Nebalus\Webapi\Repository\MySqlUserRepository;
use Nebalus\Webapi\Repository\MySqlReferralRepository;

class UserLoginService
{
    private MySqlUserRepository $mySqlUserRepository;
    public function __construct(
        MySqlUserRepository $mySqlUserRepository,
    ) {
        $this->mySqlUserRepository = $mySqlUserRepository;
    }

    public function action()
    {
        $this->mySqlUserRepository->getUserFromId(1);
    }
}
