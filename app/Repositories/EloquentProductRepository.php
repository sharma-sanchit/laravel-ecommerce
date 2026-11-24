<?php

namespace App\Repositories;

use App\Contracts\ProductRepositoryInterface;
use App\Models\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class EloquentProductRepository implements ProductRepositoryInterface
{
    public function getAllProducts(): LengthAwarePaginator
    {
        return Product::query()
            ->orderBy('id')
            ->paginate(5);
    }

    public function getProductById(int $id): Product
    {
        return Product::findOrFail($id);
    }

    public function createProduct(array $data): Product
    {
        return Product::create($data);
    }

    public function updateProduct(int $id, array $data): Product
    {
        $product = Product::findOrFail($id);

        $product->update($data);

        return $product->refresh();
    }

    public function deleteProduct(int $id): void
    {
        $product = Product::findOrFail($id);

        $product->delete();
    }
}
