<?php

namespace App\Service\Validator;

use App\Exception\ValidateException;
use Symfony\Component\Validator\Validator\ValidatorInterface;

readonly class ProductValidator implements ValidatorService
{
    public function __construct(private ValidatorInterface $validator)
    {}

    public function validate($paramsRequest): void
    {
        $dataValidate = $this->validator->validate($paramsRequest);
        if (count($dataValidate) > 0) {
            foreach ($dataValidate as $item) {
                $errors = '[' . $item->getPropertyPath() . '] ' . $item->getMessage();
                throw new ValidateException($dataValidate, $errors);
            }
        }
    }
}
