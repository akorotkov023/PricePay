<?php

namespace App\Controller\api;

use App\Dto\CalculatePriceRequestDto;
use App\Dto\PurchaseRequestDto;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class TransactionController extends AbstractController
{
    #[Route('/calculate-price', name: 'app_calculate_price', methods: ['POST'], format: 'json')]
    public function calculate(
        #[MapRequestPayload(
            acceptFormat: 'json',
            validationGroups: ['strict', 'read'],
            validationFailedStatusCode: Response::HTTP_UNPROCESSABLE_ENTITY
        )]
        CalculatePriceRequestDto $calculatePriceRequest, ValidatorInterface $validator
    ): JsonResponse
    {
        $dataValidate = $validator->validate($calculatePriceRequest);

        if (count($dataValidate) > 0) {
            $errors = [];
            foreach ($dataValidate as $item) {
                $errors[$item->getPropertyPath()] = $item->getMessage();
            }
            return new JsonResponse(['errors' => $errors], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        //TODO выбрать продукт
        //TODO рассчитать итоговую цену с учетом купона (если применим) и налога

        return new JsonResponse(['message' => 'success'], Response::HTTP_OK);
    }

    #[Route('/purchase', name: 'app_purchase', methods: ['POST'], format: 'json')]
    public function purchase(
        #[MapRequestPayload(
            acceptFormat: 'json',
            validationGroups: ['strict', 'read'],
            validationFailedStatusCode: Response::HTTP_UNPROCESSABLE_ENTITY
        )]
        PurchaseRequestDto $purchaseRequestDto, ValidatorInterface $validator
    ): JsonResponse
    {
        $dataValidate = $validator->validate($purchaseRequestDto);

        if (count($dataValidate) > 0) {
            $errors = [];
            foreach ($dataValidate as $violation) {
                $errors[$violation->getPropertyPath()] = $violation->getMessage();
            }
            return new JsonResponse(['errors' => $errors], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        //TODO использовать PaypalPaymentProcessor::pay() или StripePaymentProcessor::processPayment() для проведения платежа

        return new JsonResponse(['message' => 'success'], Response::HTTP_OK);
    }
}
