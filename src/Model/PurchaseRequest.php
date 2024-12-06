<?php

namespace App\Model;

use Symfony\Component\Validator\Constraints as Assert;

class PurchaseRequest extends CalculatePriceRequest
{
    #[Assert\NotBlank]
    #[Assert\Type(type: "string")]
//    #[Assert\Choice(
//        choices: ['paypal', 'stripe']
//    )]
    public mixed $paymentProcessor;

    public function __construct(mixed $product, mixed $taxNumber, mixed $couponCode, mixed $paymentProcessor)
    {
        parent::__construct($product, $taxNumber, $couponCode);
        $this->paymentProcessor = $paymentProcessor;
    }

}
