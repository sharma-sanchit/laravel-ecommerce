<?php

namespace App\Services;

use App\Contracts\PaymentGateway;

class StripePaymentService implements PaymentGateway
{
    public function pay(float $amount): array
    {
        return [
            'success' => true,
            'gateway' => 'Stripe',
            'amount' => $amount,
            'transaction_id' => 'STRIPE_' . uniqid(),
            'message' => 'Payment processed successfully',
        ];
    }
}
