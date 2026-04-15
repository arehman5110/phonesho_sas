<?php

namespace App\Services;

use App\Models\Product;
use App\Models\StockMovement;
use Illuminate\Support\Facades\DB;

class StockService
{
    // -----------------------------------------------
    // Add stock to a product
    // -----------------------------------------------
    public function addStock(
        Product $product,
        int     $quantity,
        string  $type         = 'manual',
        string  $note         = null,
        string  $referenceType = null,
        int     $referenceId   = null
    ): StockMovement {
        return DB::transaction(function () use (
            $product, $quantity, $type, $note,
            $referenceType, $referenceId
        ) {
            // Create movement record
            $movement = StockMovement::create([
                'shop_id'        => $product->shop_id,
                'product_id'     => $product->id,
                'user_id'        => auth()->id(),
                'type'           => $type,
                'quantity'       => abs($quantity),
                'note'           => $note,
                'reference_type' => $referenceType,
                'reference_id'   => $referenceId,
            ]);

            // Increase stock
            $product->increment('stock', abs($quantity));

            return $movement;
        });
    }

    // -----------------------------------------------
    // Remove stock from a product
    // -----------------------------------------------
    public function removeStock(
        Product $product,
        int     $quantity,
        string  $type         = 'sale',
        string  $note         = null,
        string  $referenceType = null,
        int     $referenceId   = null
    ): StockMovement {
        return DB::transaction(function () use (
            $product, $quantity, $type, $note,
            $referenceType, $referenceId
        ) {
            $movement = StockMovement::create([
                'shop_id'        => $product->shop_id,
                'product_id'     => $product->id,
                'user_id'        => auth()->id(),
                'type'           => $type,
                'quantity'       => -abs($quantity),
                'note'           => $note,
                'reference_type' => $referenceType,
                'reference_id'   => $referenceId,
            ]);

            // Decrease stock — allow negative
            $product->decrement('stock', abs($quantity));

            return $movement;
        });
    }


    // -----------------------------------------------
    // Core movement creator
    // -----------------------------------------------
    private function createMovement(
        Product $product,
        int $quantity,
        string $type,
        string $note = null,
        string $referenceType = null,
        int $referenceId = null
    ): StockMovement {
        return DB::transaction(function () use (
            $product, $quantity, $type,
            $note, $referenceType, $referenceId
        ) {
            $stockBefore = $product->stock;
            $stockAfter  = $stockBefore + $quantity;

            $movement = StockMovement::create([
                'shop_id'        => $product->shop_id,
                'product_id'     => $product->id,
                'user_id'        => auth()->id(),
                'type'           => $type,
                'quantity'       => $quantity,
                'stock_before'   => $stockBefore,
                'stock_after'    => $stockAfter,
                'reference_type' => $referenceType,
                'reference_id'   => $referenceId,
                'note'           => $note,
            ]);

            $product->update(['stock' => $stockAfter]);

            return $movement;
        });
    }

    // -----------------------------------------------
    // Get stock history for a product
    // -----------------------------------------------
    public function getHistory(Product $product, int $limit = 50)
    {
        return $product->stockMovements()
                       ->with('user')
                       ->latest()
                       ->limit($limit)
                       ->get();
    }

    // -----------------------------------------------
    // Get low stock products for a shop
    // -----------------------------------------------
    public function getLowStockProducts(int $shopId)
    {
        return Product::forShop($shopId)
                      ->active()
                      ->lowStock()
                      ->with(['category', 'brand'])
                      ->get();
    }

    // -----------------------------------------------
    // Get out of stock products
    // -----------------------------------------------
    public function getOutOfStockProducts(int $shopId)
    {
        return Product::forShop($shopId)
                      ->active()
                      ->outOfStock()
                      ->with(['category', 'brand'])
                      ->get();
    }
}