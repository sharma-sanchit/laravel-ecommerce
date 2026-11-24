<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderRequest;
use App\Models\Order;
use App\Models\Product;
use App\Services\OrderService;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function store(StoreOrderRequest $request, OrderService $service): JsonResponse
    {
        /* $validated = $request->validated();

        $order = DB::transaction(function () use ($validated){
            $order = Order::create([
                'customer_name' => $validated['customer_name'],
                'total_amount' => 0,
                'status' => 'pending',
            ]);
            $total = 0;
    
            foreach($validated['items'] as $item){
                $product = Product::findOrFail($item['product_id']);
                $price = $product->price;
                $qty = $item['quantity'];

                $order->items()->create([
                    'product_id'=> $product->id,
                    'quantity' => $qty,
                    'price' => $price
                ]);
                $total += $price * $qty;
            }
            $order->update([
                'total_amount' => $total
            ]);

            return $order->load('items.product');
        });

        return response()->json([
            'success' => true,
            'message' => 'Order created successfully',
            'data' => $order
        ], 201); */
        $order = $service->createOrder($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Order created successfully',
            'data' => $order
        ], 201);
    }

    public function show(OrderService $service, int $id): JsonResponse
    {
        /* $order = Order::with('items.product')->findOrFail($id);
        return response()->json([
            'success' => true,
            'data' => $order
        ]); */

        $order = $service->getOrderById($id);

        return response()->json([
            'success' => true,
            'data' => $order,
        ]);
    }
}
