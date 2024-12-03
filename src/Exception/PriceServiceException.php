<?php

namespace App\Exception;

class PriceServiceException extends \RuntimeException
{
    public function __construct()
    {
        parent::__construct('price service error');
    }
}
