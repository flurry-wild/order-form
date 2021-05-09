<?php

namespace App;

class Order extends BaseModel
{
    protected $fillable = [
        'name', 'rate_id', 'date', 'address'
    ];
}
