<?php

namespace App\Services;

use App\Contracts\ProductRepositoryInterface;
use App\Models\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ProductService
{

    public function __construct(private ProductRepositoryInterface $productRepository){}
    public function getAllProducts(): LengthAwarePaginator
    {
        // return Product::query()
        //     ->orderBy('id')
        //     ->paginate(5);

        return $this->productRepository->getAllProducts();
    }

    public function getProductById(int $id): ?Product
    {
        // return Product::findOrFail($id);
        return $this->productRepository->getProductById($id);
    }
    
    public function createProduct(array $data): Product
    {
        // return Product::create($data);
        return $this->productRepository->createProduct($data);
    }

    public function updateProduct(int $id, array $data): Product
    {
        // $product = Product::findOrFail($id);

        // $product->update($data);

        // return $product->refresh();
        return $this->productRepository->updateProduct($id, $data);
    }

    public function deleteProduct(int $id): void
    {
        // $product = Product::findOrFail($id);
        // $product->delete();
        $this->productRepository->deleteProduct($id);
    }
}
