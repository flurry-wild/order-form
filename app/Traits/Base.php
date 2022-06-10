<?php

namespace App\Traits;

use App\Clients\DadataClient;
use App\Services\OrderService;

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
        $this->dadataClient = new DadataClient();
    }
}
