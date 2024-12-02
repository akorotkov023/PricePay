<?php

namespace App\Service;

readonly class Price
{
    public function __construct(private int $total, private int $coupon, private int $nds)
    {
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
