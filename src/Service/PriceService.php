<?php

namespace App\Service;

use App\Model\CalculatePriceRequest;
use App\Repository\CouponRepository;
use App\Repository\ProductRepository;

readonly class PriceService
{

    public function __construct(
        private ProductRepository $productRepository,
        private CouponRepository $couponRepository
    ){}
    public function calcPrice(CalculatePriceRequest $request): Price
    {
        // то цена будет 116.56 евро (100 евро - 6% скидка + налог 24%).

        $amount = $this->productRepository->find($request->product);
        $coupon = $this->couponRepository->findOneBy(['code' => $request->couponCode]);

        $country = substr($request->taxNumber, 0, 2);
        $nds = match ($country) {
            'DE' => 1900,
            'IT' => 2200,
            'FR' => 2000,
            'GR' => 2400,
            default => 0,
        };

        $total = $amount->getPrice() - $coupon->getValue() + $nds;

        return new Price($total, $coupon->getValue(), $nds);
    }
}
