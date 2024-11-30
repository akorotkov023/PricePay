<?php

namespace App\Service\Validator;

use App\Dto\ProductNumber;
use App\Dto\TaxNumber;

readonly final class RequestValidator
{
    public ProductNumber $productId;
    public TaxNumber $taxNumber;

    public function __construct(
        public string $product,
        public string $tax,
        public string $couponCode,
    ) {
        $this->productId =  new ProductNumber($product);
        $this->taxNumber = new TaxNumber($tax);
    }

    public function getResult(): string
    {
        return $this->taxNumber->getValue();
    }

}
