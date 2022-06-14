<?php

namespace App\Domain\ValueObject;

use App\Domain\BaseModel;

class Rate extends BaseModel {
    const DAYS_NUMBERS = [0, 1, 2, 3, 4, 5, 6];

    protected $fillable = [
        'name', 'price', 'days'
    ];

    /**
     * @return array
     */
    public function getForbiddenDays() {
        return array_diff(self::DAYS_NUMBERS, json_decode($this->days));
    }
}
