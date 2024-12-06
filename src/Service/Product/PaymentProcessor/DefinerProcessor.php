<?php

namespace App\Service\Product\PaymentProcessor;

use InvalidArgumentException;

class DefinerProcessor
{
    public static function define($arg): Definer
    {
        if ($arg === 'paypal') {
            return new PaypalProcessor();
        } elseif ($arg === 'stripe') {
            return new StripeProcessor();
        }

        throw new InvalidArgumentException('Unsupported paymentProcessor');
    }

}
