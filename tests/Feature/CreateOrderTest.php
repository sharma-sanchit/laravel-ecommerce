<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Facades\DB;

class CreateOrderTest extends TestCase
{
    use RefreshDatabase;

    public function test_order_can_be_created_successfully(): void
    {
        $product = Product::create([
            'name' => 'Keyboard',
            'price' => 800,
        ]);

        $response = $this->postJson('/api/orders', [
            'customer_name' => 'Test Customer',
            'items' => [
                [
                    'product_id' => $product->id,
                    'quantity' => 2,
                ],
            ],
        ]);

        $response->assertCreated()
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.customer_name', 'Test Customer')
            ->assertJsonPath('data.total_amount', 1600);

        $this->assertDatabaseHas('orders', [
            'customer_name' => 'Test Customer',
            'total_amount' => 1600,
        ]);

        $this->assertDatabaseHas('order_items', [
            'product_id' => $product->id,
            'quantity' => 2,
            'price' => 800,
        ]);
    }

    public function test_order_requires_valid_data(): void
    {
        $response = $this->postJson('/api/orders', [
            'customer_name' => '',
            'items' => [],
        ]);

        $response->assertUnprocessable()
            ->assertJsonValidationErrors([
                'customer_name',
                'items',
            ]);

        $this->assertDatabaseCount('orders', 0);
    }

    public function test_missing_order_returns_not_found(): void
    {
        $response = $this->getJson('/api/orders/999999');

        $response->assertNotFound();
    }


    public function test_transaction_rolls_back_order_when_an_operation_fails(): void
    {
        try {
            DB::transaction(function () {
                Order::create([
                    'customer_name' => 'Rollback Customer',
                    'total_amount' => 0,
                    'status' => 'pending',
                ]);

                throw new \RuntimeException('Simulated failure');
            });
        } catch (\RuntimeException $exception) {
            $this->assertSame(
                'Simulated failure',
                $exception->getMessage()
            );
        }

        $this->assertDatabaseMissing('orders', [
            'customer_name' => 'Rollback Customer',
        ]);
    }

}
