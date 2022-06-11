<?php

namespace App\UseCase;

use App\Traits\Base;
use Illuminate\Foundation\Http\FormRequest;

class CreateOrderForm {
    use Base;

    /**
     * @var \Illuminate\Foundation\Http\FormRequest '
     */
    private $request;

    /**
     * @param \Illuminate\Foundation\Http\FormRequest $request
     */
    public function __construct(FormRequest $request) {
        $this->initializeBaseDependencies();

        $this->request = $request;
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
