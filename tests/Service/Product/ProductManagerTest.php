<?php

namespace App\Tests\Service\Product;

use App\Exception\ProductNotFoundException;
use App\Model\CalculatePriceRequest;
use App\Repository\ProductRepository;
use App\Service\Product\Handler\RequestHandleInterface;
use App\Service\Product\ProductManager;
use App\Service\Validator\ValidatorService;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class ProductManagerTest extends TestCase
{
    private ValidatorService $productValidatorMock;
    private ProductRepository $productRepositoryMock;
    private RequestHandleInterface $requestHandleMock;
    private ProductManager $productManager;

    protected function setUp(): void
    {
        parent::setUp();

        $this->productValidatorMock = $this->createMock(ValidatorService::class);
        $this->productRepositoryMock = $this->createMock(ProductRepository::class);
        $this->requestHandleMock = $this->createMock(RequestHandleInterface::class);

        $this->productManager = new ProductManager(
            $this->productValidatorMock,
            $this->productRepositoryMock,
            $this->requestHandleMock
        );
    }

    public function testCalculateReturnSuccessResponse()
    {
        $request = new CalculatePriceRequest(1, 'tax_number', 'coupon_code');
        $expectedResponseData = ['result' => 'some_result'];

        $this->productValidatorMock
            ->expects($this->once())
            ->method('validate')
            ->with($this->equalTo($request));

        $this->productRepositoryMock
            ->expects($this->once())
            ->method('existsById')
            ->with($this->equalTo($request->product))
            ->willReturn(true);

        $this->requestHandleMock
            ->expects($this->once())
            ->method('handle')
            ->with($this->equalTo($request))
            ->willReturn($expectedResponseData);

        $response = $this->productManager->calculate($request);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $this->assertEquals(json_encode(['message' => 'success', 'details' => $expectedResponseData]), $response->getContent());
    }

    public function testCalculateException()
    {
        $request = new CalculatePriceRequest(1, 'tax_number', 'coupon_code');

        $this->productValidatorMock
            ->expects($this->once())
            ->method('validate')
            ->with($this->equalTo($request));

        $this->productRepositoryMock
            ->expects($this->once())
            ->method('existsById')
            ->with($this->equalTo($request->product))
            ->willReturn(false);

        $this->expectException(ProductNotFoundException::class);

        $this->productManager->calculate($request);
    }

    public function testCalculateValidateRequest()
    {
        $request = new CalculatePriceRequest(1, 'tax_number', 'coupon_code');

        $this->productValidatorMock
            ->expects($this->once())
            ->method('validate')
            ->with($this->equalTo($request));

        $this->productRepositoryMock
            ->expects($this->once())
            ->method('existsById')
            ->with($this->equalTo($request->product))
            ->willReturn(true);

        $this->productManager->calculate($request);
    }
}
