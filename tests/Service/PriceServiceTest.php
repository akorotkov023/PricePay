<?php

namespace App\Tests\Service;

use App\Entity\Product;
use App\Entity\CountryTax;
use App\Entity\Coupon;
use App\Repository\CountryTaxRepository;
use App\Repository\CouponRepository;
use App\Repository\ProductRepository;
use App\Service\PriceService;
use App\Tests\AbstractTestCase;
use App\Tests\MockUtils;

class PriceServiceTest extends AbstractTestCase
{

    private ProductRepository $productRepository;
    private CouponRepository $couponRepository;
    private CountryTaxRepository $countryTaxRepository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->productRepository = $this->createMock(ProductRepository::class);
        $this->couponRepository = $this->createMock(CouponRepository::class);
        $this->countryTaxRepository = $this->createMock(CountryTaxRepository::class);
    }

    public function testCalcPriceWithCoupon()
    {
        $productId = 1;
        $taxNumber = 'DE123456789';
        $couponCode = 'P15';

        $this->productRepository->expects($this->once())
            ->method('find')
            ->with($productId)
            ->willReturn($this->createProductEntity());

        $this->couponRepository->expects($this->once())
            ->method('findOneBy')
            ->with(['code' => $couponCode])
            ->willReturn($this->createCouponEntity());

        $slug = substr($taxNumber, 0, 2);
        $this->countryTaxRepository->expects($this->once())
            ->method('findOneBy')
            ->with(['slug' => $slug])
            ->willReturn($this->createCountryTaxEntity());

        $couponFlag = true;
        $coupon = $this->couponRepository->findOneBy(['code' => $couponCode]);
        $product = $this->productRepository->find($productId);
        $price = $product->getPrice();
        $tax = $this->countryTaxRepository->findOneBy(['slug' => $slug])->getTax();

        $discountedPrice = $couponFlag && $coupon->getType() === 'percentage'
            ? $price - ($price * ($coupon->getValue() / 100))
            : $price - $coupon->getValue();

        $total = $discountedPrice + ($discountedPrice * ($tax / 100));

        $this->assertEquals(11656, $total);

    }

    private function createProductEntity(): Product
    {
        $product = MockUtils::createProduct();
        $this->setEntityId($product, 1);

        return $product;
    }

    private function createCouponEntity(): Coupon
    {
        $coupon = MockUtils::createCoupon();
        $this->setEntityId($coupon, 1);

        return $coupon;
    }

    private function createCountryTaxEntity(): CountryTax
    {
        $tax = MockUtils::createTax();
        $this->setEntityId($tax, 1);

        return $tax;
    }

}
