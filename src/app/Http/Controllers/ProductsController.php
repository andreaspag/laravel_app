<?php

namespace App\Http\Controllers;

use App\Repositories\Interfaces\ProductsRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Resources\ProductCollection;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Services\ProductService;


class ProductsController extends Controller
{
    public function __construct(private ProductsRepositoryInterface $productRepository) {

    }

    public function all(Request $request) {

        $categoryFilter = $request->query('category');
        if (empty($categoryFilter)) {
            return new ProductCollection($this->productRepository->all());
        } else {
            return new ProductCollection($this->productRepository->findByCategoryName($categoryFilter));
        }
    }

    public function create(Request $request) {

        $validator = Validator::make($request->all(), [
            'name' => 'required|regex:/(^([a-zA-Z\s\-_]+)$)/u|max:10',
            'code' => 'required|unique:products|regex:/(^[a-z\-_]+)$/u',
            'category' => ['required', new \App\Rules\CategoryExists()],
            'price'     => 'required|decimal:0,2/',
            'release_date' => 'required|date',
            'tags'   => 'array',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'NOK', 'errors' => $validator->errors()->toArray()], 422);
        }

        if ((new ProductService($this->productRepository))->storeProduct($validator->validated())) {
            return response()->json(['status' => 'OK', 'mesage' => 'Product stored'], 200);
        }

        return response()->json(['status' => 'NOK', 'message' => 'Failed to create product'], 500);
    }

    public function update(Request $request) {

        $input = $request->all();
        $product = Product::findOrFail($input['id'] ?? null);

        $validator = Validator::make($input, [
            'name' => 'required|regex:/(^([a-zA-Z\s\-_]+)$)/u|max:10',
            'code' => ['required', Rule::unique('products')->ignore($product->id), 'regex:/(^[a-z\-_]+)$/u'],
            'category' => ['required', new \App\Rules\CategoryExists()],
            'price'     => 'required|decimal:0,2/',
            'release_date' => 'required|date',
            'tags'   => 'array',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'NOK', 'errors' => $validator->errors()->toArray()], 422);
        }
        $validated = $validator->validated();

        if ((new ProductService($this->productRepository))->updateProduct($product, $validator->validated())) {
            return response()->json(['status' => 'OK', 'mesage' => 'Product updated'], 200);
        }
        return response()->json(['status' => 'NOK', 'message' => 'Failed to update product'], 500);
    }

}
