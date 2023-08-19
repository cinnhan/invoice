<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class InvoiceItem extends BaseModel
{
    use SoftDeletes;

    protected $table = 'invoice_invoice_items';

}
