<?php

namespace App\Services;

use Fomvasss\Dadata\Facades\DadataSuggest;
use Exception;

class OrderService
{
    /**
     * @param string $query
     * @return mixed
     */
    public function getDadataAddressVariants($query)
    {
        try {
            $response = DadataSuggest::suggest("address", ["query" => $query, "count" => 4]);

            $result = [];
            if (isset($response['unrestricted_value'])) {
                $result[0] = $response['unrestricted_value'];
            } else {
                foreach ($response as $key => $item) {
                    $result[$key] = $item["unrestricted_value"];
                }
            }

            return $result;

        } catch (Exception $e) {
            return null;
        }
    }
}
