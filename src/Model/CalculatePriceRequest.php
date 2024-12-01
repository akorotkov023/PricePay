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
    #[Assert\Regex(
        pattern: '/^(DE|IT|FR|GR)\d{9}$|^FR[A-Z]\d{9}$/'
    )]
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
