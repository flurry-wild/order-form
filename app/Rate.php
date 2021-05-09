<?php

namespace App;

use App\Models\BaseModel;

class Rate extends BaseModel
{
    protected $fillable = [
        'name', 'price', 'days'
    ];
}
