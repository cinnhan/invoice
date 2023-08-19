<?php

namespace App\Repositories;

use App\Models\InvoiceItem;

class InvoiceItemRepository extends BaseRepository
{

    public function getModel()
    {
        return InvoiceItem::class;
    }

}
