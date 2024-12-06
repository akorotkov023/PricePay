<?php

namespace App\Service\Product\Purchase;
interface PurchaseServiceInterface
{
    public function purchase(int $price): string;

}
