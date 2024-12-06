<?php

namespace App\Exception;

use Symfony\Component\Validator\ConstraintViolationListInterface;

class ValidateException extends \RuntimeException
{
    public function __construct(private readonly ConstraintViolationListInterface $violations, string $error = 'Validate error')
    {
        parent::__construct($error);
    }

    public function getViolations(): ConstraintViolationListInterface
    {
        return $this->violations;
    }
}
