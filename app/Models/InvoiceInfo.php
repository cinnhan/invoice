<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class InvoiceInfo extends BaseModel
{
    use SoftDeletes;

    protected $table = 'invoice_invoice_info';

}
