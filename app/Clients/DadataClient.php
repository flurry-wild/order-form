<?php

namespace App\Clients;

use Exception;

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
            $dadata = new \Dadata\DadataClient(
                '96f70fb0318823d889463bee64374e7cd405dff4',
                'd4eea85a694dba5b16710af04b0ff531a3f94e44'
            );

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
