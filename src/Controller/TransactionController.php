<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class TransactionController extends AbstractController
{
    #[Route('/calculate-price', name: 'app_calculate-price', methods: ['POST'])]
    public function calculate(): JsonResponse
    {

        return $this->json(['price' => 1000], 200);
    }

    #[Route('/purchase', name: 'app_purchase', methods: ['POST'])]
    public function purchase(): JsonResponse
    {
        return $this->json(['price' => 1000], 200);
    }
}
