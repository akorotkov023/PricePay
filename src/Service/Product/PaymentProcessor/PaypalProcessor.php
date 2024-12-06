<?php

namespace App\Service\Product\PaymentProcessor;

use Systemeio\TestForCandidates\PaymentProcessor\PaypalPaymentProcessor;

class PaypalProcessor extends PaypalPaymentProcessor implements Definer
{
    public function payment(int $price): string
    {
        // Дополнительная логика для расширенного процессора платежей

        return 'Payment sent to paypal with price = ' . $price;

    }

}
