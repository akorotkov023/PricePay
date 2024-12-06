<?php

namespace App\Service\Product\Price;

use App\Exception\PriceServiceException;
use App\Repository\CountryTaxRepository;
use App\Repository\CouponRepository;
use App\Repository\ProductRepository;

final readonly class PriceService implements PriceServiceInterface
{
    public function __construct(
        private ProductRepository $productRepository,
        private CouponRepository $couponRepository,
        private CountryTaxRepository $countryTaxRepository,
    ){}
    public function calculatePrice($productDataRequest): Price
    {
        try {
            $product = $this->productRepository->find($productDataRequest->getProduct());
            $coupon = $this->couponRepository->findOneBy(['code' => $productDataRequest->getCouponCode()]);
            $slug = substr($productDataRequest->getTaxNumber(), 0, 2);
            $tax = $this->countryTaxRepository->findOneBy(['slug' => $slug]);

            $price = $product->getPrice();
            $couponPrice = $coupon ? $this->applyCoupon($price, $coupon) : 0;
            $total = $this->applyTax($price - $couponPrice, $tax);

            return new Price($total, $couponPrice, $tax->getTax());

        } catch (PriceServiceException) {
            throw new PriceServiceException();
        }
    }

    private function applyCoupon(float $price, $coupon): int {
        if ($coupon->getType() === 'percentage') {
            return $price * ($coupon->getValue() / 100);
        }
        return $coupon->getValue();
    }

    private function applyTax(int $price, $tax): int {
        return $price + ($price * ($tax->getTax() / 100));
    }
}
