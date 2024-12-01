<?php

namespace App\Tests\Dto;

use App\Model\CalculatePriceRequest;
use PHPUnit\Framework\TestCase;

class CalculatePriceRequestDtoTest extends TestCase
{
    public function testProductIsNotBlank()
    {
        $product = 123;
        $taxNumber = 'DE123456789';
        $couponCode = 'P10';

        $dto = new CalculatePriceRequest($product, $taxNumber, $couponCode);

        $this->assertEquals($product, $dto->product, 'Product should be initialized correctly');
        $this->assertEquals($taxNumber, $dto->taxNumber, 'Tax ID should be initialized correctly');
        $this->assertEquals($couponCode, $dto->couponCode, 'Currency should be initialized correctly');
    }

    public function testProductIsNull()
    {
        $product = null;
        $taxNumber = 'DE123456789';
        $couponCode = 'P30';

        $dto = new CalculatePriceRequest($product, $taxNumber, $couponCode);

        $this->assertNull($dto->product, 'Product should be null');
    }

    public function testTaxNumberIsEmpty()
    {
        $product = 123;
        $taxNumber = '';
        $couponCode = 'F20';

        $dto = new CalculatePriceRequest($product, $taxNumber, $couponCode);

        $this->assertEquals($product, $dto->product, 'Product should be initialized correctly');
        $this->assertEquals('', $dto->taxNumber, 'Tax ID should be empty');
        $this->assertEquals($couponCode, $dto->couponCode, 'Currency should be initialized correctly');
    }

    public function testCouponCodeIsNull()
    {
        $product = 123;
        $taxNumber = 'DE123456789';
        $couponCode = null;

        $dto = new CalculatePriceRequest($product, $taxNumber, $couponCode);

        $this->assertEquals($product, $dto->product, 'Product should be initialized correctly');
        $this->assertEquals($taxNumber, $dto->taxNumber, 'Tax ID should be initialized correctly');
        $this->assertNull($dto->couponCode, 'Coupon code should be null');
    }

    public function testAllFieldsAreNull()
    {
        $product = null;
        $taxNumber = null;
        $couponCode = null;

        $dto = new CalculatePriceRequest($product, $taxNumber, $couponCode);

        $this->assertNull($dto->product, 'Product should be null');
        $this->assertNull($dto->taxNumber, 'Tax ID should be null');
        $this->assertNull($dto->couponCode, 'Coupon code should be null');
    }

    public function testProductIsNegative()
    {
        $product = -123;
        $taxNumber = 'DE123456789';
        $couponCode = 'P15';

        $dto = new CalculatePriceRequest($product, $taxNumber, $couponCode);

        $this->assertEquals($product, $dto->product, 'Product should be initialized correctly');
        $this->assertEquals($taxNumber, $dto->taxNumber, 'Tax ID should be initialized correctly');
        $this->assertEquals($couponCode, $dto->couponCode, 'Currency should be initialized correctly');
    }

    public function testTaxNumberIsInvalidFormat()
    {
        $product = 123;
        $taxNumber = 'INVALID_TAX_NUMBER';
        $couponCode = 'P30';

        $dto = new CalculatePriceRequest($product, $taxNumber, $couponCode);

        $this->assertEquals($product, $dto->product, 'Product should be initialized correctly');
        $this->assertEquals($taxNumber, $dto->taxNumber, 'Tax ID should be initialized correctly');
        $this->assertEquals($couponCode, $dto->couponCode, 'Currency should be initialized correctly');
    }

    public function testCouponCodeIsEmptyString()
    {

        $product = 123;
        $taxNumber = 'DE123456789';
        $couponCode = '';

        $dto = new CalculatePriceRequest($product, $taxNumber, $couponCode);

        $this->assertEquals($product, $dto->product, 'Product should be initialized correctly');
        $this->assertEquals($taxNumber, $dto->taxNumber, 'Tax ID should be initialized correctly');
        $this->assertEquals('', $dto->couponCode, 'Coupon code should be an empty string');
    }
}
