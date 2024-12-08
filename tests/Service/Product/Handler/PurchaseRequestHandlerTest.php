<?php

namespace App\Tests\Service\Product\Handler;

use App\Model\PurchaseRequest;
use App\Service\Product\Handler\PurchaseRequestHandler;
use App\Service\Product\PaymentProcessor\DefinerProcessor;
use App\Service\Product\Price\Price;
use App\Service\Product\Price\PriceServiceInterface;
use App\Service\Product\Purchase\PurchaseService;
use PHPUnit\Framework\TestCase;

class PurchaseRequestHandlerTest extends TestCase
{
    private PriceServiceInterface $priceServiceMock;
    private PurchaseRequestHandler $purchaseRequestHandler;

    protected function setUp(): void
    {
        parent::setUp();

        $this->priceServiceMock = $this->createMock(PriceServiceInterface::class);
        $this->purchaseRequestHandler = new PurchaseRequestHandler($this->priceServiceMock);
    }

    public function testMakePaymentReturnResult()
    {
        $price = new Price(10000, 1000, 500);

        $this->priceServiceMock->expects($this->once())
            ->method('calculatePrice')
            ->willReturn($price);

        $request = new PurchaseRequest(1, 'tax_number', 'coupon_code', 'paypal');
        $expect = $this->purchaseRequestHandler->makePayment($request);

        $defineProcessor = DefinerProcessor::define('paypal');
        $processor = new PurchaseService($defineProcessor);
        $result = $processor->purchase($price->getTotal());

        $this->assertEquals($expect, ["result" => $result]);
    }

}
