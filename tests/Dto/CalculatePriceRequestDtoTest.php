<?php

namespace App\Tests\Dto;

use App\Dto\CalculatePriceRequestDto;
use App\Service\Redis\Connector;
use App\Service\Redis\ConnectorFacade;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CalculatePriceRequestDtoTest extends TestCase
{
    public function testProductIsNotBlank()
    {
        $product = 123; // Пример идентификатора продукта
        $taxNumber = 'DE123456789'; // Пример налогового идентификатора
        $couponCode = 'EUR'; // Пример валюты

        $dto = new CalculatePriceRequestDto($product, $taxNumber, $couponCode);

        $this->assertEquals($product, $dto->product, 'Product should be initialized correctly');
        $this->assertEquals($taxNumber, $dto->taxNumber, 'Tax ID should be initialized correctly');
        $this->assertEquals($couponCode, $dto->couponCode, 'Currency should be initialized correctly');
    }
}
