<?php

namespace App\Service\Product\PaymentProcessor;

use Systemeio\TestForCandidates\PaymentProcessor\StripePaymentProcessor;

class StripeProcessor extends StripePaymentProcessor implements Definer
{
    public function payment(int $price): string
    {
        // Дополнительная логика для расширенного процессора платежей

        return 'Payment sent to stripe with price = ' . $price;

    }

}
