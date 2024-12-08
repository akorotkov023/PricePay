<?php

namespace App\Exception;

class PriceArgumentException extends \RuntimeException
{
    public function __construct($text)
    {
        parent::__construct($text);
    }
}
