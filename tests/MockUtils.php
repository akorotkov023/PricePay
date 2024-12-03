<?php

namespace App\Tests;

use App\Entity\CountryTax;
use App\Entity\Coupon;
use App\Entity\Product;

class MockUtils
{
    public static function createProduct(): Product
    {
        return (new Product())
            ->setId(1)
            ->setName('test')
            ->setPrice(10000);
    }

    public static function createCoupon(): Coupon
    {
        return (new Coupon())
            ->setId(1)
            ->setCode('P6')
            ->setType('percentage')
            ->setValue(6);
    }

    public static function createTax(): CountryTax
    {
        return (new CountryTax())
            ->setId(1)
            ->setSlug('IT')
            ->setCountry('Италия')
            ->setTax(24);
    }
}
