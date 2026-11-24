<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use App\Http\Requests\StoreProductRequest;
use App\Http\Resources\ProductResource;
use App\Http\Requests\UpdateProductRequest;
use App\Services\ProductService;

class ProductController extends Controller
{
    public function index(ProductService $productService)
    {
        // $products = Product::all();
        /* $products = Product::query()
            ->orderBy('id')
            ->paginate(3);

        return response()->json([
            'success' => true,
            'data' => $products->items(),
            'pagination' => [
                'current_page' => $products->currentPage(),
                'per_page' => $products->perPage(),
                'total' => $products->total(),
                'last_page' => $products->lastPage(),
            ]
        ]); */

        return ProductResource::collection(
                $productService->getAllProducts()
            );
    }


    public function show(ProductService $service, int $id)
    {
        /* $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'success' => false,
                'message' => 'Product not found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $product,
        ]); */
        return new ProductResource($service->getProductById($id));
    }

    public function store(StoreProductRequest $request, ProductService $service): JsonResponse
    {
        $product = $service->createProduct($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Product created successfully',
            'data' => new ProductResource($product),
        ], 201);
    }

    public function update(UpdateProductRequest $request, ProductService $service, $id): JsonResponse
    {
        $product = $service->updateProduct($id, $request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Product updated successfully',
            'data' => new ProductResource($product),
        ]);
    }

    public function destroy(ProductService $service, int $id): JsonResponse
    {
        $service->deleteProduct($id);

        return response()->json([
            'success' => true,
            'message' => 'Product deleted successfully',
        ]);
    }
}
