<?php

namespace App\Service\Product\PaymentProcessor;

interface Definer
{
    public function payment(int $price): string;
}
