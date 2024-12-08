<?php

namespace App\Service\Product\Handler;

use App\Model\CalculatePriceRequest;
use App\Service\Product\Price\PriceServiceInterface;
use App\Service\Product\ProductData;

readonly class CalculatePriceRequestHandler
{
    public function __construct(
        private PriceServiceInterface $priceService
    ){}

    public function getPrice(CalculatePriceRequest $request): array
    {
        $productDataRequest = new ProductData(
            $request->product,
            $request->taxNumber,
            $request->couponCode
        );

        $price = $this->priceService->calculatePrice($productDataRequest);
        return [
            'price' => $price->getTotal(),
            'coupon' => $price->getCoupon() ?? 0,
            'nds' => $price->getNds() ?? 0
        ];
    }
}
