<?php

namespace App\Service\Product\Handler;

use App\Model\PurchaseRequest;
use App\Service\Product\PaymentProcessor\DefinerProcessor;
use App\Service\Product\Price\PriceServiceInterface;
use App\Service\Product\ProductData;
use App\Service\Product\Purchase\PurchaseService;

readonly class PurchaseRequestHandler
{
    public function __construct(
        private PriceServiceInterface $priceService,
    ){}

    public function makePayment(PurchaseRequest $request): array
    {
        $productDataRequest = new ProductData(
            $request->product,
            $request->taxNumber,
            $request->couponCode,
            $request->paymentProcessor ?? null
        );

        $price = $this->priceService->calculatePrice($productDataRequest);

        $defineProcessor = DefinerProcessor::define($productDataRequest->getPaymentProcessor());
        $processor = new PurchaseService($defineProcessor);

        $result = $processor->purchase($price->getTotal());

        return ['result' => $result];
    }
}
