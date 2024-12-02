<?php

namespace App\Service;

use App\Model\PurchaseRequest;

class PurchaseService
{
    public function purchase(PurchaseRequest $request): string
    {
        //TODO использовать PaypalPaymentProcessor::pay() или StripePaymentProcessor::processPayment() для проведения платежа
        $price = 1000;

        $type = $request->paymentProcessor;
        try{
            return match ($type) {
                'paypal' => 'Payment sent to paypal',
                'stripe' => 'Payment sent to stripe',
                default => 0,
            };

        }catch (\Exception $exception){
            throw new \InvalidArgumentException($exception->getMessage());
        }
    }
}
