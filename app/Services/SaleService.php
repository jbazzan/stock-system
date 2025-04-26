<?php

namespace App\Services;

use App\Models\Sale;
use Illuminate\Support\Facades\DB;

class SaleService
{
    public function calculateTotal(int $id): Sale
    {
        return DB::transaction(function () use($id) 
        {
            $sale = Sale::find($id);
            $discount = $sale->discount;

            if (!$sale) {
                throw new \Exception('Sale not found.');
            }

            $total = 0;

            foreach ($sale->details as $detail)
            {
                $total += $detail['subtotal'];
            }

            if($discount?->active === 1)
            {
                $percentage = floatval($discount->percentage);

                $totalWithDiscount = $total * (1 - $percentage / 100);

                $sale->update([
                    'subtotal'=>$total,
                    'total'=>$totalWithDiscount
                ]);
                
            }
            else
            {   
                $sale->update([
                    'subtotal'=>$total,
                    'total'=>$total
                ]);
            }

            return $sale;
        });
    }
}