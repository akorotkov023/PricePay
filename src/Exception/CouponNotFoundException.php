<?php

namespace App\Exception;

class CouponNotFoundException extends \RuntimeException
{
    public function __construct()
    {
        parent::__construct('coupon not found');
    }
}
