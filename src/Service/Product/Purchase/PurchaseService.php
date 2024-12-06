<?php

namespace App\Service\Product\Purchase;

use App\Service\Product\PaymentProcessor\Definer;

final class PurchaseService implements PurchaseServiceInterface
{
    private Definer $definer;

    public function __construct(Definer $definer)
    {
        $this->definer = $definer;
    }

    public function purchase(int $price): string
    {
        return $this->definer->payment($price);
    }
}
