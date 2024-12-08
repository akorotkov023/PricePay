<?php

namespace App\Tests\Service\Product\Handler;

use App\Model\CalculatePriceRequest;
use App\Model\PurchaseRequest;
use App\Service\Product\Handler\CalculatePriceRequestHandler;
use App\Service\Product\Handler\PurchaseRequestHandler;
use App\Service\Product\Price\Price;
use App\Service\Product\Price\PriceServiceInterface;
use App\Service\Product\ProductData;
use PHPUnit\Framework\TestCase;

class CalculatePriceRequestHandlerTest extends TestCase
{

    private PriceServiceInterface $priceServiceMock;
    private CalculatePriceRequestHandler $handler;

    protected function setUp(): void
    {
        parent::setUp();

        $this->priceServiceMock = $this->createMock(PriceServiceInterface::class);
        $this->handler = new CalculatePriceRequestHandler($this->priceServiceMock);
    }

    public function testGetPriceReturnCorrectData()
    {
        $productDataRequest = new ProductData(1, 'tax_number', 'coupon_code');
        $price = new Price(10000, 1000, 500);

        $this->priceServiceMock
            ->method('calculatePrice')
            ->with($this->equalTo($productDataRequest))
            ->willReturn($price);

        $request = new CalculatePriceRequest(1, 'tax_number', 'coupon_code');
        $result = $this->handler->getPrice($request);

        $this->assertEquals([
            'price' => 10000,
            'coupon' => 1000,
            'nds' => 500
        ], $result);
    }
}
