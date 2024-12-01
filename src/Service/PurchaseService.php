<?php

namespace App\Service;

use App\Exception\CouponNotFoundException;
use App\Exception\ProductNotFoundException;
use App\Model\CalculatePriceRequest;
use App\Model\PurchaseRequest;
use App\Repository\CouponRepository;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validator\ValidatorInterface;

readonly class PurchaseService
{
    public function __construct(
        private ProductRepository $productRepository,
        private CouponRepository  $couponRepository,
        private ValidatorInterface $validator
    ){}

    public function calculate(PurchaseRequest $request): JsonResponse
    {
        $dataValidate = $this->validator->validate($request);

        if (count($dataValidate) > 0) {
            $errors = [];
            foreach ($dataValidate as $item) {
                $errors[$item->getPropertyPath()] = $item->getMessage();
            }
            return new JsonResponse(['message' => 'input params error', 'details' => $errors], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        if (!$this->productRepository->existsById($request->product)) {
            throw new ProductNotFoundException();
        }

        if (!$this->couponRepository->existsByCode($request->couponCode)) {
            throw new CouponNotFoundException();
        }

//        dd($request);
        //TODO рассчитать итоговую цену с учетом купона (если применим) и налога

        return new JsonResponse(['message' => 'success'], Response::HTTP_OK);
    }
}
