<?php

namespace App\Clients;

use Exception;
use Illuminate\Support\Facades\Config;

class DadataClient
{
    /**
     * @param string $query
     *
     * @return mixed
     */
    public function getDadataAddressVariants(string $query)
    {
        try {
            $dadata = new \Dadata\DadataClient(Config::get('dadata.token'), Config::get('dadata.secret'));

            $response = $dadata->suggest("address", $query, 4);

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
            throw new Exception('Dadata error' . $e->getMessage());
        }
    }
}
