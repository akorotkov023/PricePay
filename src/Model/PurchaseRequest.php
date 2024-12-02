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
        pattern: '/^(DE|IT|FR|GR)\d{9}$|^FR[A-Z]\d{9}$/'
    )]
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
