<?php

namespace App\Http\Controllers;

use App\Domain\ValueObject\Rate;
use App\Http\Requests\StoreOrderPost;
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
     * @param StoreOrderPost $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreOrderPost $request) {
        try {
            $form = new CreateOrderForm($request);
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
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function addressHints(Request $request) {
        try {
            $query = $request->input('query');

            return response()->json($this->dadataClient->getDadataAddressVariants($query));
        } catch (Exception $e) {
            abort(500, $e->getMessage());
        }
    }
}
