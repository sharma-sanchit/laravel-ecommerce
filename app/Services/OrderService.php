<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class OrderService
{
    public function createOrder(array $data): Order
    {
        return DB::transaction(function () use ($data) {
            $order = Order::create([
                'customer_name' => $data['customer_name'],
                'total_amount' => 0,
                'status' => 'pending',
            ]);

            $total = 0;

            foreach ($data['items'] as $item) {
                $product = Product::findOrFail(
                    $item['product_id']
                );

                $price = $product->price;
                $quantity = $item['quantity'];

                $order->items()->create([
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'price' => $price,
                ]);

                $total += $price * $quantity;
            }

            $order->update([
                'total_amount' => $total,
            ]);

            return $order->load('items.product');
        });
    }

    public function getOrderById(int $id): Order
    {
        return Order::with('items.product')->findOrFail($id);
    }
}
