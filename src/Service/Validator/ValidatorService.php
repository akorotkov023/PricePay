<?php

namespace App\Service\Validator;
interface ValidatorService
{
    public function validate($paramsRequest): void;
}
