<?php

namespace App\UseCase;

use App\Http\Requests\StoreOrderPost;
use App\Services\OrderService;

class CreateOrderForm {

    /**
     * @var \Illuminate\Foundation\Http\FormRequest
     */
    private $request;

    /**
     * @var \App\Services\OrderService
     */
    private $orderService;

    /**
     * @param \App\Http\Requests\StoreOrderPost $request
     * @param \App\Services\OrderService        $orderService
     */
    public function __construct(StoreOrderPost $request, OrderService $orderService) {
        $this->request = $request;
        $this->orderService = $orderService;
    }

    /**
     * @return void
     *
     * @throws \Exception
     */
    public function process() {
        $this->orderService->createOrderWithUser($this->request);
    }
}
