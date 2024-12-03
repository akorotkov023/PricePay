<?php

namespace App\Service;

use App\Exception\PriceServiceException;
use App\Model\CalculatePriceRequest;
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
        // то цена будет 116.56 евро (100 евро - 6% скидка + налог 24%).
//        dd($productDataRequest);
        try {
            $product = $this->productRepository->find($productDataRequest->getProduct());
            $coupon = $this->couponRepository->findOneBy(['code' => $productDataRequest->getCouponCode()]);
            $slug = substr($productDataRequest->getTaxNumber(), 0, 2);
            $tax = $this->countryTaxRepository->findOneBy(['slug' => $slug]);
            $couponPrice = 0;
            if ($coupon) {
                $couponPrice = $coupon->getValue();
            }
            //TODO рассчитать проценты правильно
            $total = $product->getPrice() - $couponPrice + $tax->getTax();

            return new Price($total, $couponPrice, $tax->getTax());

        } catch (PriceServiceException) {
            throw new PriceServiceException();
        }
    }
}
