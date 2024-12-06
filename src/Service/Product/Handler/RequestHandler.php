<?php

namespace App\Service\Product\Handler;

use App\Model\CalculatePriceRequest;
use App\Model\PurchaseRequest;
use InvalidArgumentException;

class RequestHandler implements RequestHandleInterface
{
    private CalculatePriceRequestHandler $calculatePriceHandler;
    private PurchaseRequestHandler $purchaseHandler;

    public function __construct(CalculatePriceRequestHandler $calculatePriceHandler, PurchaseRequestHandler $purchaseHandler)
    {
        $this->calculatePriceHandler = $calculatePriceHandler;
        $this->purchaseHandler = $purchaseHandler;
    }

    public function handle($request): array
    {
        if ($request instanceof PurchaseRequest)  {
            return $this->purchaseHandler->makePayment($request);
        } elseif ($request instanceof CalculatePriceRequest){
            return $this->calculatePriceHandler->getPrice($request);
        } else {
            throw new InvalidArgumentException('Unsupported request type');
        }
    }

}
