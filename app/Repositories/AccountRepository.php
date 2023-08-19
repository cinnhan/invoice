<?php

namespace App\Repositories;

use App\Models\Account;

class AccountRepository extends BaseRepository
{

    public function getModel()
    {
        return Account::class;
    }

}
