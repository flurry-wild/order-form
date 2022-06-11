<?php

namespace App\Traits;

use App\Clients\DadataClient;
use App\Services\OrderService;
use Illuminate\Support\Facades\Config;

trait Base
{
    /**
     * @var OrderService $orderService
     */
    public $orderService;

    /**
     * @var DadataClient $dadataClient
     */
    public $dadataClient;

    /**
     * @return void
     */
    public function initializeBaseDependencies() {
        $this->orderService = new OrderService();

        $this->dadataClient = new DadataClient(Config::get('dadata.token'), Config::get('dadata.secret'));
    }
}
