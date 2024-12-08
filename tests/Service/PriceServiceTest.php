<?php

namespace App\Tests\Service;

use App\Entity\Product;
use App\Entity\CountryTax;
use App\Entity\Coupon;
use App\Exception\PriceServiceException;
use App\Repository\CountryTaxRepository;
use App\Repository\CouponRepository;
use App\Repository\ProductRepository;
use App\Service\Product\Price\Price;
use App\Service\Product\Price\PriceService;
use App\Service\Product\ProductData;
use App\Tests\AbstractTestCase;
use App\Tests\MockUtils;

class PriceServiceTest extends AbstractTestCase
{

    private ProductRepository $productRepositoryMock;
    private CouponRepository $couponRepositoryMock;
    private CountryTaxRepository $countryTaxRepositoryMock;
    private PriceService $priceService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->productRepositoryMock = $this->createMock(ProductRepository::class);
        $this->couponRepositoryMock = $this->createMock(CouponRepository::class);
        $this->countryTaxRepositoryMock = $this->createMock(CountryTaxRepository::class);

        $this->priceService = new PriceService(
            $this->productRepositoryMock,
            $this->couponRepositoryMock,
            $this->countryTaxRepositoryMock
        );

    }

    public function testCalcPriceWithCoupon()
    {
        $productDataRequest = new ProductData(1, 'tax_number', 'coupon_code');
        $this->productRepositoryMock->expects($this->once())
            ->method('find')
            ->with($productDataRequest->getProduct())
            ->willReturn($this->createProductEntity());

        $this->couponRepositoryMock->expects($this->once())
            ->method('findOneBy')
            ->with(['code' => $productDataRequest->getCouponCode()])
            ->willReturn($this->createCouponEntity());

        $slug = substr($productDataRequest->getTaxNumber(), 0, 2);
        $this->countryTaxRepositoryMock->expects($this->once())
            ->method('findOneBy')
            ->with(['slug' => $slug])
            ->willReturn($this->createCountryTaxEntity());

        $price = $this->priceService->calculatePrice($productDataRequest);

        $this->assertInstanceOf(Price::class, $price);
        $this->assertEquals(11656, $price->getTotal());
    }

    public function testCalculatePriceWithoutCoupon()
    {
        $productDataRequest = new ProductData(1, 'tax_number', null);
        $this->productRepositoryMock->expects($this->once())
            ->method('find')
            ->with($productDataRequest->getProduct())
            ->willReturn($this->createProductEntity());

        $this->couponRepositoryMock->expects($this->once())
            ->method('findOneBy')
            ->with(['code' => $productDataRequest->getCouponCode()])
            ->willReturn(null);

        $slug = substr($productDataRequest->getTaxNumber(), 0, 2);
        $this->countryTaxRepositoryMock->expects($this->once())
            ->method('findOneBy')
            ->with(['slug' => $slug])
            ->willReturn($this->createCountryTaxEntity());

        $price = $this->priceService->calculatePrice($productDataRequest);

        $this->assertInstanceOf(Price::class, $price);
        $this->assertEquals(12400, $price->getTotal());
        $this->assertEquals(0, $price->getCoupon());
        $this->assertEquals(24, $price->getNds());
    }

    public function testCalculatePriceThrowsException()
    {
        $productDataRequest = new ProductData(1, 'tax_number', 'coupon_code');

        $this->productRepositoryMock
            ->method('find')
            ->with($this->equalTo($productDataRequest->getProduct()))
            ->willThrowException(new PriceServiceException());

        $this->expectException(PriceServiceException::class);

        $this->priceService->calculatePrice($productDataRequest);
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
