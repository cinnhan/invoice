<?php

namespace App\Repositories;

use App\Models\InvoiceInfo;

class InvoiceInfoRepository extends BaseRepository
{

    public function getModel()
    {
        return InvoiceInfo::class;
    }

}
