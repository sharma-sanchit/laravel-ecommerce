<?php

namespace App\Http\Controllers;

use App\Contracts\PaymentGateway;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class PaymentController extends Controller
{
    public function pay(
        Request $request,
        PaymentGateway $gateway
    ): JsonResponse {

        $validated = $request->validate([
            'amount' => ['required', 'numeric', 'min:1'],
        ]);

        $result = $gateway->pay(
            (float) $validated['amount']
        );

        return response()->json([
            'success' => true,
            'data' => $result,
        ]);
    }
}
