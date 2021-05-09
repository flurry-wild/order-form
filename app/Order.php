<?php

namespace App;

use App\Models\BaseModel;

class Order extends BaseModel
{
    protected $fillable = [
        'name', 'phone', 'rate_id', 'date', 'address'
    ];
}
