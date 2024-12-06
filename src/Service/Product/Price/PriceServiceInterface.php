<?php

namespace App\Service\Product\Price;

interface PriceServiceInterface
{
    public function calculatePrice($productDataRequest): Price;

}
