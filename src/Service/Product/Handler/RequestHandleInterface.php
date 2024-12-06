<?php

namespace App\Service\Product\Handler;
interface RequestHandleInterface
{
    public function handle($request): array;
}
