<?php

namespace App\Http\Controllers;

use App\Helpers\ExchangeRateHelper;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use InvalidArgumentException;

class ExchangeRateController extends Controller {

    public function getRatesForCurrency(Request $request)
    : JsonResponse {

        try {
            $currency = $request->route('currency');

            return response()->json(ExchangeRateHelper::getRatesForCurrency($currency), Response::HTTP_OK);
        } catch (InvalidArgumentException $ex) {
            return response()->json(['error' => $ex->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }
}
