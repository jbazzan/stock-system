<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSaleDetailRequest;
use App\Http\Requests\UpdateSaleDetailRequest;
use App\Models\Product;
use App\Models\SaleDetail;
use Illuminate\Support\Facades\DB;

class SaleDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $saleDetail=SaleDetail::with(['sale','product'])->get();
        return response()->json($saleDetail);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSaleDetailRequest $request)
    {
        return DB::transaction(function() use($request)
        {
            $product=Product::find($request->product_id);
            $subtotal=$request->quantity * $product->price;
            
            $saleDetail=SaleDetail::create([
                'sale_id'=>$request->sale_id,
                'product_id'=>$request->product_id,
                'quantity'=>$request->quantity,
                'subtotal'=>$subtotal,
            ]);

            return response()->json($saleDetail->load(['sale','product']));

        });
    }/*  */

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $saleDetail=SaleDetail::find($id);
        return response()->json($saleDetail->load(['sale','product']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSaleDetailRequest $request, string $id)
    {
        $saleDetail=SaleDetail::find($id);
        if($request->has('product_id') && $request->has('quantity'))
        {
            $product=Product::find($request->product_id);
            $subtotal=$request->quantity * $product->price;
        }
        else if ($request->has('product_id'))
        {
            $product=Product::find($request->product_id);
            $subtotal=$saleDetail->quantity * $product->price;
        }
        else
        {
            $subtotal=$request->quantity * $saleDetail->product->price;
        }
        $saleDetail->update([
            'product_id'=>$request->product_id ?? $saleDetail->product_id,
            'quantity'=>$request->quantity ?? $saleDetail->quantity,
            'subtotal'=>$subtotal
        ]);
    }
    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $saleDetail=SaleDetail::find($id);
        $saleDetail->delete();
        return response()->json(null,204);
    }
}
