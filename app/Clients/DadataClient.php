<?php

namespace App\Clients;

use Exception;
use Dadata\DadataClient as VendorDadataClient;

class DadataClient extends VendorDadataClient {

    /**
     * @param $token
     * @param $secret
     */
    public function __construct($token, $secret) {
        parent::__construct($token, $secret);
    }

    /**
     * @param string $query
     *
     * @return array
     *
     * @throws \Exception
     */
    public function getDadataAddressVariants(string $query) {
        try {
            $response = $this->suggest("address", $query, 4);

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
