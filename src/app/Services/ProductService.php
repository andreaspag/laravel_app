<?php

namespace App\Services;

use App\Models\Product;
use App\Repositories\Interfaces\ProductsRepositoryInterface;
use App\Services\External\ExternalService;

class ProductService
{


    public function __construct(private ProductsRepositoryInterface $productsRepository) {

    }

    /**
     * Store a new product in the datastore
     * @param array $payload
     * @return bool
     */
    public function storeProduct(array $payload): bool {
        if($product = $this->productsRepository->store($payload)) {
            (new ExternalService())->notifyProductCreated($product);
            return true;
        }
        return false;
    }

    /**
     * Update an existing product
     * @param Product $product
     * @param array $payload
     * @return bool
     */
    public function updateProduct(Product $product, array $payload): bool {
        if ($product = $this->productsRepository->update($product, $payload)) {
            (new ExternalService())->notifyProductUpdated($product);
            return true;
        }
        return false;
    }


}
