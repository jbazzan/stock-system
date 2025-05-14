<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSaleRequest;
use App\Http\Requests\UpdateSaleRequest;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\SaleResource;
use App\Models\Sale;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index():JsonResource
    {
        return SaleResource::collection(Sale::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSaleRequest $request)
    {
        $sale=Sale::create($request->validated());
        return response()->json([
            'message'=>'Sale created in successfully.',
            'sale' => $sale
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $sale=Sale::find($id);
        return response()->json($sale->load(['client','details','discount']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSaleRequest $request, string $id)
    {
        $sale=Sale::find($id);
        $sale->update($request->validated());
        return response()->json(['message'=>'Sale updated in successfully.']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $sale=Sale::find($id);
        $sale->delete();
        return response()->json(null,204);
    }

    /**
     * Find sale by client
     */


    public function getSalesByClient($clientId)
    {
        $sales = Sale::where('client_id', $clientId)
            ->get(['id', 'client_id', 'date', 'total', 'discount_id', 'subtotal']);

            return response()->json(['data' => SaleResource::collection($sales)]);
    }



    /**
     * Recalculate the sale total if a discount is applied or removed.
     */
    public function recalculate(string $id)
    {
        return DB::transaction(function () use($id) 
        {
            $sale = Sale::find($id);
            $discount = $sale->discount;

            if (!$sale) {
                return response()->json(['message' => 'Sale not found.'], 404);
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


            return response()->json($sale->load(['client']));
        });
    }
}
