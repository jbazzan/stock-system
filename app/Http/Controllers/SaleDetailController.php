<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSaleDetailRequest;
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
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $saleDetail=SaleDetail::find($id);
        $saleDetail->delete();
        return response()->json(null,204);
    }
}
