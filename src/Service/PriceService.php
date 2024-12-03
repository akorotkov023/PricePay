<?php

namespace App\Service;

use App\Exception\PriceServiceException;
use App\Repository\CountryTaxRepository;
use App\Repository\CouponRepository;
use App\Repository\ProductRepository;

readonly class PriceService
{
    public function __construct(
        private ProductRepository $productRepository,
        private CouponRepository $couponRepository,
        private CountryTaxRepository $countryTaxRepository,
    ){}
    public function calcPrice($productDataRequest): Price
    {
        try {
            $product = $this->productRepository->find($productDataRequest->getProduct());
            $coupon = $this->couponRepository->findOneBy(['code' => $productDataRequest->getCouponCode()]);
            $slug = substr($productDataRequest->getTaxNumber(), 0, 2);
            $tax = $this->countryTaxRepository->findOneBy(['slug' => $slug]);

            $couponPrice = 0;
            $couponFlag = false;
            $price = $product->getPrice();
            $tax = $tax->getTax();

            if ($coupon) {
                $couponFlag = true;
                $couponPrice = $coupon->getValue();
            }

            if ($couponFlag) {
                $discountedPrice = $coupon->getType() === 'percentage'
                    ? $price - ($price * ($couponPrice / 100))
                    : $price - $couponPrice;

                $total = $discountedPrice + ($discountedPrice * ($tax / 100));

                return new Price($total, $couponPrice, $tax);
            }

            $total = $price + ($price * ($tax / 100));

            return new Price($total, $couponPrice, $tax);

        } catch (PriceServiceException) {
            throw new PriceServiceException();
        }
    }
}
