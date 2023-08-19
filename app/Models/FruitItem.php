<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;

class FruitItem extends BaseModel
{
    use SoftDeletes;

    protected $table = 'invoice_fruit_items';

}
