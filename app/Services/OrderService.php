<?php

namespace App\Services;

use App\Order;
use App\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;
use Exception;

class OrderService
{
    public function createOrderWithUser(FormRequest $request)
    {
        try {
            DB::beginTransaction();

            $order = Order::create($request->all());

            $user = User::firstOrCreate(
                ['phone' => $request->input('phone')],
                ['name' => $request->input('name')]
            );

            /** @var Order */
            $order->setUserId($user->id);

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();

            throw new Exception("Can not save order " . $e->getMessage());
        }
    }
}
