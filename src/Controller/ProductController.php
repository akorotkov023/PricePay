<?php

namespace App\Controller;

use App\Model\CalculatePriceRequest;
use App\Model\PurchaseRequest;
use App\Service\Product\ProductManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

class ProductController extends AbstractController
{
    #[Route(path: '/calculate-price', methods: ['POST'], format: 'json')]
    public function calc(#[MapRequestPayload(
        acceptFormat: 'json',
        validationGroups: ['strict', 'read'],
        validationFailedStatusCode: Response::HTTP_UNPROCESSABLE_ENTITY
    )] CalculatePriceRequest $calculatePriceRequest, ProductManagerInterface $productManager
    ): JsonResponse
    {
        return $productManager->calculate($calculatePriceRequest);
    }

    #[Route(path: '/purchase', methods: ['POST'], format: 'json')]
    public function purchase(#[MapRequestPayload(
        acceptFormat: 'json',
        validationGroups: ['strict', 'read'],
        validationFailedStatusCode: Response::HTTP_UNPROCESSABLE_ENTITY
    )] PurchaseRequest $purchaseRequest, ProductManagerInterface $productManager
    ): JsonResponse
    {
        return $productManager->calculate($purchaseRequest);
    }
}
