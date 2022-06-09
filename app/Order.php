<?php

namespace App;

class Order extends BaseModel
{
    protected $fillable = [
        'name', 'rate_id', 'date', 'address'
    ];

    public function setUserId($userId) {
        $this->user_id = $userId;
        $this->save();
    }
}
