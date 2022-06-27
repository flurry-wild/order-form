<?php

namespace App\Http\Controllers;

use App\Clients\DadataClient;
use App\Domain\ValueObject\Rate;
use App\Http\Requests\StoreOrderPost;
use App\Services\OrderService;
use App\UseCase\CreateOrderForm;
use Exception;
use Illuminate\Http\Request;

/**
 * Class OrderController
 * @package App\Http\Controllers
 */
class OrderController extends Controller {

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create() {
        $rates = Rate::get();

        return view('order.create', compact('rates'));
    }

    /**
     * @param \App\Http\Requests\StoreOrderPost $request
     * @param \App\Services\OrderService        $orderService
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreOrderPost $request, OrderService $orderService) {
        try {
            $form = new CreateOrderForm($request, $orderService);
            $form->process();
        } catch (Exception $e) {
            abort(500, $e->getMessage());
        }

        return response()->json(["result" => "success"]);
    }

    /**
     * @param int $rateId
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function forbiddenRateDays(int $rateId) {
        $rate = Rate::find($rateId);

        if (!$rate instanceof Rate) {
            abort(404);
        }

        return response()->json(["forbiddenDays" => $rate->getForbiddenDays()]);
    }

    /**
     * @param \Illuminate\Http\Request  $request
     * @param \App\Clients\DadataClient $dadataClient
     *
     * @return \Illuminate\Http\JsonResponse|void
     */
    public function addressHints(Request $request, DadataClient $dadataClient) {
        try {
            $query = $request->input('query');

            return response()->json($dadataClient->getDadataAddressVariants($query));
        } catch (Exception $e) {
            abort(500, $e->getMessage());
        }
    }
}
