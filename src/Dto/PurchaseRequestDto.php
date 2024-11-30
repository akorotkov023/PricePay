<?php

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;



class PurchaseRequestDto
{
    #[Assert\NotBlank]
    #[Assert\Type(type: "integer")]
    #[Assert\Positive]
    public mixed $product;

    #[Assert\NotBlank]
    #[Assert\Regex(
        pattern: '/^(DE|IT|FR|GR)\d{9}$|^FR[A-Z]\d{9}$/'
    )]
    public mixed $taxNumber;

    #[Assert\NotBlank]
    #[Assert\Length(max: 3)]
    public mixed $couponCode;

    #[Assert\NotBlank]
    #[Assert\Type(type: "string")]
    #[Assert\Choice(
        choices: ['paypal', 'stripe'],
        message: 'Choose payment processor'
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
