<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderPost;
use App\Order;
use App\Rate;
use App\User;
use Illuminate\Http\Request;
use Fomvasss\Dadata\Facades\DadataSuggest;
use Exception;

class OrderController extends Controller
{
    const DAYS_NUMBERS = [0, 1, 2, 3, 4, 5, 6];

    public function create()
    {
        $rates = Rate::get();

        return view('order.create', compact('rates'));
    }

    public function store(StoreOrderPost $request)
    {
        Order::create($request->all());

        $phone = $request->input('phone');

        $existUser = User::where('phone', $phone)->first();
        if (empty($existUser)) {
            $user = new User();
            $user->name = $request->input('name');
            $user->phone = $phone;

            $user->save();
        }
    }

    public function forbiddenRateDays($rateId)
    {
        $rate = Rate::find($rateId);

        if (!$rate instanceof Rate) abort(404);

        $forbiddenDays = array_diff(self::DAYS_NUMBERS, json_decode($rate->days));

        return response(json_encode(["forbiddenDays" => $forbiddenDays]));
    }

    public function addressHints(Request $request)
    {
        try {
            $query = $request->input('query');
            $response = DadataSuggest::suggest("address", ["query" => $query, "count" => 4]);

            $result = [];
            if (isset($response['unrestricted_value'])) {
                $result[0] = $response['unrestricted_value'];
            } else {
                foreach ($response as $key => $item) {
                    $result[$key] = $item["unrestricted_value"];
                }
            }

            return response(json_encode($result, JSON_UNESCAPED_UNICODE));
        } catch (Exception $e) {
            abort(500);
        }
    }
}
