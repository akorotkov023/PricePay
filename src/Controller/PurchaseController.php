<?php

namespace App\Controller;

use App\Model\PurchaseRequest;
use App\Service\PurchaseService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

class PurchaseController extends AbstractController
{
    #[Route(path: '/purchase', methods: ['POST'], format: 'json')]
    public function purchase(#[MapRequestPayload(
        acceptFormat: 'json',
        validationGroups: ['strict', 'read'],
        validationFailedStatusCode: Response::HTTP_UNPROCESSABLE_ENTITY
    )] PurchaseRequest $purchaseRequest, PurchaseService $purchaseService
    ): JsonResponse
    {
        return $purchaseService->purchase($purchaseRequest);
    }
}
