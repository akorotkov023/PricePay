<?php

namespace App\Service;

use App\Exception\CouponNotFoundException;
use App\Exception\ProductNotFoundException;
use App\Model\CalculatePriceRequest;
use App\Model\PurchaseRequest;
use App\Repository\CouponRepository;
use App\Repository\ProductRepository;
use InvalidArgumentException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Validator\ValidatorInterface;

readonly class ProductService
{
    public function __construct(
        private ProductRepository  $productRepository,
        private CouponRepository   $couponRepository,
        private ValidatorInterface $validator,
        private PriceService       $priceService,
        private PurchaseService    $purchaseService,
    ){}
    public function calculate($request): JsonResponse
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

        $res = [];
        if ($request instanceof CalculatePriceRequest) {
            //рассчитать итоговую цену
            $price = $this->priceService->calcPrice($request);
            $res['price'] = $price->getTotal();
            $res['coupon'] = $price->getCoupon();
            $res['nds'] = $price->getNds();
        } elseif ($request instanceof PurchaseRequest) {
            //провести платеж
            $res['result'] = $this->purchaseService->purchase($request);
        } else {
            throw new InvalidArgumentException('Unsupported request type');
        }

        return new JsonResponse(['message' => 'success', 'details' => $res], Response::HTTP_OK);
    }
}
