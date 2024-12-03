<?php

namespace App\Service;

use App\Model\PurchaseRequest;

class PurchaseService
{
    public function purchase($productDataRequest, int $price): string
    {
        //TODO использовать PaypalPaymentProcessor::pay() или StripePaymentProcessor::processPayment() для проведения платежа

        $type = $productDataRequest->getPaymentProcessor();
        try{
            return match ($type) {
                'paypal' => 'Payment sent to paypal with price = ' . $price,
                'stripe' => 'Payment sent to stripe with price = ' . $price,
                default => 0,
            };

        }catch (\Exception $exception){
            throw new \InvalidArgumentException($exception->getMessage());
        }
    }
}
