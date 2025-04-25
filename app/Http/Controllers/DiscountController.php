<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDiscountRequest;
use App\Http\Requests\UpdateDiscountRequest;
use App\Http\Resources\DiscountResource;
use App\Models\Discount;
use Illuminate\Http\Resources\Json\JsonResource;

class DiscountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index():JsonResource
    {
        return DiscountResource::collection(Discount::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDiscountRequest $request)
    {
        $discount=Discount::create($request->validated());
        return response()->json(['message'=>'Discount created in successfully.']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id):JsonResource
    {
        $discount=Discount::find($id);
        return new DiscountResource($discount);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDiscountRequest $request, string $id)
    {
        $discount=Discount::find($id);
        $discount->update($request->validated());
        return response()->json(['message'=>'Discount updated in successfully.']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $discount=Discount::find($id);
        $discount->delete();
        return response()->json(null, 204);
    }
}
