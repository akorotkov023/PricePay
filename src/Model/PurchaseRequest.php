<?php

namespace App\Model;

use Symfony\Component\Validator\Constraints as Assert;

class PurchaseRequest
{
    #[Assert\NotBlank]
    #[Assert\Type(type: "integer")]
    #[Assert\Positive]
    public mixed $product;

    #[Assert\NotBlank]
    #[Assert\Type(type: "string")]
    #[Assert\Regex(
        pattern: '/^(FR[A-Z]{2}\d{9}|DE\d{9}|GR\d{9}|IT\d{10})$/'
    )]
    #[Assert\Length(max: 13)]
    public mixed $taxNumber;

    #[Assert\NotBlank]
    #[Assert\Type(type: "string")]
    #[Assert\Length(max: 3)]
    public mixed $couponCode;

    #[Assert\NotBlank]
    #[Assert\Type(type: "string")]
    #[Assert\Choice(
        choices: ['paypal', 'stripe']
    )]
    public mixed $paymentProcessor;

    public function __construct(mixed $product, mixed $taxNumber, mixed $couponCode, mixed $paymentProcessor)
    {
        $this->product = $product;
        $this->taxNumber = $taxNumber;
        $this->couponCode = $couponCode;
        $this->paymentProcessor = $paymentProcessor;
    }

}
