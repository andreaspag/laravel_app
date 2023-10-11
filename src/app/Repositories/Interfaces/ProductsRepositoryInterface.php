<?php

namespace App\Repositories\Interfaces;

use App\Models\Product;
use Illuminate\Support\Collection;

interface ProductsRepositoryInterface
{
    public function all(): Collection;
    public function findById(int $productId): ?Product;
    public function findByCategoryName(string $categoryName): Collection;

    public function store(array $payload): ?Product;

    public function update(Product $product, array $payload): Product;
}
