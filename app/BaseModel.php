<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Exception;
use Illuminate\Support\Facades\Log;

class BaseModel extends Model
{
    public function save(array $options = [])
    {
        try {
            return parent::save($options);
        } catch (Exception $e) {
            Log::channel('errorlog')->error($e->getMessage());
            return false;
        }
    }
}