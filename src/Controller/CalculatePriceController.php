<?php

namespace App\Controller;

use App\Model\CalculatePriceRequest;
use App\Service\CalculateService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

class CalculatePriceController extends AbstractController
{
    #[Route(path: '/calculate-price', methods: ['POST'], format: 'json')]
    public function calc(#[MapRequestPayload(
        acceptFormat: 'json',
        validationGroups: ['strict', 'read'],
        validationFailedStatusCode: Response::HTTP_UNPROCESSABLE_ENTITY
    )] CalculatePriceRequest $calculatePriceRequest, CalculateService $calculateService
    ): JsonResponse
    {
        return $calculateService->calculate($calculatePriceRequest);
    }
}
