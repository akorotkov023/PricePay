<?php

namespace App\Service\Product;

use App\Exception\ProductNotFoundException;
use App\Repository\ProductRepository;
use App\Service\Product\Handler\RequestHandleInterface;
use App\Service\Validator\ValidatorService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

final readonly class ProductManager implements ProductManagerInterface
{
    public function __construct(
        private ValidatorService  $productValidator,
        private ProductRepository $productRepository,
        private RequestHandleInterface $requestHandle,
    ){}
    public function calculate($request): JsonResponse
    {
        $this->productValidator->validate($request);

        if (!$this->productRepository->existsById($request->product)) {
            throw new ProductNotFoundException();
        }

        $res = $this->requestHandle->handle($request);

        return new JsonResponse(['message' => 'success', 'details' => $res], Response::HTTP_OK);
    }
}
