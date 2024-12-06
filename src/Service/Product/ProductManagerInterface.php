<?php

namespace App\Service\Product;

use Symfony\Component\HttpFoundation\JsonResponse;

interface ProductManagerInterface
{
    public function calculate($request): JsonResponse;
}
