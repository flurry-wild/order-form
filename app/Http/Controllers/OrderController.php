<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderPost;
use App\Order;
use App\Rate;
use App\User;
use Illuminate\Http\Request;
use Fomvasss\Dadata\Facades\DadataSuggest;
use Exception;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    const DAYS_NUMBERS = [0, 1, 2, 3, 4, 5, 6];

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $rates = Rate::get();

        return view('order.create', compact('rates'));
    }

    /**
     * @param StoreOrderPost $request
     */
    public function store(StoreOrderPost $request)
    {
        $order = Order::create($request->all());

        $phone = $request->input('phone');

        DB::transaction(function() use ($phone, $order, $request) {
            $user = User::where('phone', $phone)->first();
            if (empty($user)) {
                $user = new User();
                $user->name = $request->input('name');
                $user->phone = $phone;

                $user->save();
            }

            $order->user_id = $user->id;
            $order->save();
        });
    }

    /**
     * @param integer $rateId
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function forbiddenRateDays($rateId)
    {
        $rate = Rate::find($rateId);

        if (!$rate instanceof Rate) abort(404);

        $forbiddenDays = array_diff(self::DAYS_NUMBERS, json_decode($rate->days));

        return response(json_encode(["forbiddenDays" => $forbiddenDays]));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
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
