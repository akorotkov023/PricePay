<?php

namespace App\Model;

use Symfony\Component\Validator\Constraints as Assert;

class CalculatePriceRequest
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
    #[Assert\Length(max: 3)]
    public mixed $couponCode;

    public function __construct(mixed $product, mixed $taxNumber, mixed $couponCode)
    {
        $this->product = $product;
        $this->taxNumber = $taxNumber;
        $this->couponCode = $couponCode;
    }

}
