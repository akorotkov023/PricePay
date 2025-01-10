<?php

namespace App\Tests;

use App\Entity\Country;
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

    public static function createCountry(): Country
    {
        return (new Country())
            ->setSlug('IT')
            ->setCountry('Италия');
    }
    public static function createTax(): CountryTax
    {
        return (new CountryTax())
            ->setTax(24);
    }

}
