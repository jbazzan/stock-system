<?php

namespace App\Observers;

use App\Models\SaleDetail;
use App\Services\StockService;
use App\Services\SaleService;

class SaleDetailObserver
{
    protected $stockService;
    protected $saleService;

    public function __construct(StockService $stockService, SaleService $saleService)
    {
        $this->stockService=$stockService;
        $this->saleService=$saleService;
    }
    /**
     * Handle the SaleDetail "created" event.
     */
    public function created(SaleDetail $saleDetail): void
    {
       $this->stockService->decreaseStock($saleDetail->product_id, $saleDetail->quantity);
       $this->recalculateSaleTotal($saleDetail);
    }

    /**
     * Handle the SaleDetail "updated" event.
     */
    public function updated(SaleDetail $saleDetail): void
    {
        $originalQuantity=$saleDetail->getOriginal('quantity');
        $newQuantity=$saleDetail->quantity;
        $difference=$newQuantity - $originalQuantity;

        $this->stockService->adjustStock($saleDetail->product_id, $difference);
        $this->recalculateSaleTotal($saleDetail);
    }

    /**
     * Handle the SaleDetail "deleted" event.
     */
    public function deleted(SaleDetail $saleDetail): void
    {
        $this->stockService->increaseStock($saleDetail->product_id, $saleDetail->quantity);
        $this->recalculateSaleTotal($saleDetail);
    }

    private function recalculateSaleTotal(SaleDetail $saleDetail): void
    {
        if ($saleDetail->sale_id) {
            $this->saleService->calculateTotal($saleDetail->sale_id);
        }
    }

}
