<?php

namespace App\Domain\Entity;

use App\Domain\BaseModel;

class Order extends BaseModel {
    protected $fillable = [
        'name', 'rate_id', 'date', 'address'
    ];

    /**
     * @param $userId
     *
     * @return void
     *
     * @throws \Exception
     */
    public function setUserId($userId) {
        $this->user_id = $userId;
        $this->save();
    }
}
