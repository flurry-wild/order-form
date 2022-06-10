<?php

namespace App\UseCase;

use App\Traits\Base;
use Illuminate\Foundation\Http\FormRequest;


class CreateOrderForm
{
    use Base;

    private $request;

    public function __construct(FormRequest $request)
    {
        $this->initializeBaseDependencies();

        $this->request = $request;
    }

    /**
     * @return void
     */
    public function process()
    {
        $this->orderService->createOrderWithUser($this->request);
    }
}
