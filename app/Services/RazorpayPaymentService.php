<?php

namespace App\Services;

use App\Contracts\PaymentGateway;

class RazorpayPaymentService implements PaymentGateway
{
    public function pay(float $amount): array
    {
        return [
            'success' => true,
            'gateway' => 'Razorpay',
            'amount' => $amount,
            'transaction_id' => 'RAZORPAY_' . uniqid(),
            'message' => 'Payment processed successfully',
        ];
    }
}
