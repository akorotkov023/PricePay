<?php

namespace App\Service;

readonly class Product
{
    public function __construct(private int $product,  private string $taxNumber, private string $couponCode, private ?string $paymentProcessor = null)
    {
    }

    public function getProduct(): int
    {
        return $this->product;
    }

    public function getTaxNumber(): string
    {
        return $this->taxNumber;
    }

    public function getCouponCode(): string
    {
        return $this->couponCode;
    }

    public function getPaymentProcessor(): ?string
    {
        return $this->paymentProcessor;
    }





}
