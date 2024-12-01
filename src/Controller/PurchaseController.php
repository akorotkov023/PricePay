<?php

namespace App\Controller;

use App\Model\CalculatePriceRequest;
use App\Model\PurchaseRequest;
use App\Service\CalculateService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class PurchaseController extends AbstractController
{
    #[Route(path: '/purchase', methods: ['POST'], format: 'json')]
    public function purchase(#[MapRequestPayload(
        acceptFormat: 'json',
        validationGroups: ['strict', 'read'],
        validationFailedStatusCode: Response::HTTP_UNPROCESSABLE_ENTITY
    )] PurchaseRequest $purchaseRequest, CalculateService $calculateService
    ): JsonResponse
    {
        return $calculateService->calculate($purchaseRequest);
    }

    #[Route('/purchase', name: 'app_purchase', methods: ['POST'], format: 'json')]
    public function purchase2(
        #[MapRequestPayload(
            acceptFormat: 'json',
            validationGroups: ['strict', 'read'],
            validationFailedStatusCode: Response::HTTP_UNPROCESSABLE_ENTITY
        )]
        PurchaseRequest $purchaseRequestDto, ValidatorInterface $validator
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
