<?php

namespace App\Services;

use App\Models\Product;
use Exception;

class StockService
{
    public function decreaseStock(int $productId, int $quantity):void
    {
        $product = Product::find($productId);

        if($product->stock < $quantity)
        {
            throw new Exception("Not enough stock for product: {$product->name}");
        }

        $product->decrement('stock', $quantity);
    }

    public function increaseStock(int $productId, int $quantity):void
    {
        $product = Product::find($productId);
        $product->increment('stock',$quantity);
    }

    public function adjustStock(int $productId, int $difference):void
    {
        $product = Product::find($productId);

        if($difference === 0)
        {
            return;
        }

        if($difference > 0)
        {
            $this->decreaseStock($productId, $difference);
        }
        else
        {
            $this->increaseStock($productId, abs($difference));
        }
    }
}
