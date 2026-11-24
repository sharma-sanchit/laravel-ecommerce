<?php

namespace App\Contracts;

use App\Models\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

interface ProductRepositoryInterface
{
    public function getAllProducts(): LengthAwarePaginator;

    public function getProductById(int $id): Product;

    public function createProduct(array $data): Product;

    public function updateProduct(int $id, array $data): Product;

    public function deleteProduct(int $id): void;
}
