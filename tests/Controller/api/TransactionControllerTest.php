<?php

namespace App\Tests\Controller\api;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TransactionControllerTest extends WebTestCase
{

    public function testCalculate()
    {
        $client = static::createClient();
        $client->request('POST', '/calculate-price');


    }
}
