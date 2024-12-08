<?php

namespace App\Service\Product\Price;

use App\Exception\PriceArgumentException;

readonly class Price
{
    public function __construct(private int $total, private int $coupon, private int $nds)
    {
        if ($total < 0) {
            throw new PriceArgumentException('Total price cannot be negative.');
        }
        if ($coupon < 0) {
            throw new PriceArgumentException('Coupon value cannot be negative.');
        }
        if ($nds < 0) {
            throw new PriceArgumentException('NDS value cannot be negative.');
        }
    }

    public function getTotal(): int
    {
        return $this->total;
    }

    public function getCoupon(): int
    {
        return $this->coupon;
    }

    public function getNds(): int
    {
        return $this->nds;
    }

}
