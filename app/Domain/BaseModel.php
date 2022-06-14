<?php

namespace App\Domain;

use Illuminate\Database\Eloquent\Model;
use Exception;
use Illuminate\Support\Facades\Log;

class BaseModel extends Model
{
    /**
     * @param array $options
     *
     * @return bool
     *
     * @throws Exception
     */
    public function save(array $options = [])
    {
        try {
            return parent::save($options);
        } catch (Exception $e) {
            Log::channel('errorlog')->error($e->getMessage() . implode(',', $options));

            throw new Exception($e->getMessage());
        }
    }
}
