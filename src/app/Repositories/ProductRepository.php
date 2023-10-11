<?php

namespace App\Repositories;

use App\Models\Category;
use App\Models\Tag;
use App\Repositories\Interfaces\ProductsRepositoryInterface;
use App\Models\Product;
use Illuminate\Support\Collection;

class ProductRepository implements ProductsRepositoryInterface
{
    public function all(): Collection  {
        return Product::all();
    }

    public function findById(int $productId): Product {
        return Product::find($productId);
    }

    public function findByCategoryName(string $categoryName): Collection {
        $category = Category::query()->where('category_name', $categoryName)->first();
        if ($category) {
            return Product::query()->where('category_id', $category->id)->get();
        }
        return collect([]);
    }

    public function store(array $payload): ?Product {

        $category = Category::query()->where('category_name', $payload['category'])->firstOrFail();

        $product = Product::create([
            'name' => $payload['name'],
            'code' => $payload['code'],
            'category_id' => $category->id,
            'price'  => floatval($payload['price']),
            'release_date' => $payload['release_date'],
        ]);

        if (!$product) {
            return null;
        }

        $this->syncProductTags($product, $payload['tags']);
        return $product;
    }


    public function update(Product $product, array $payload): Product {
        $productCategory       = Category::query()->where('category_name', $payload['category'])->firstOrFail();
        $product->name         = $payload['name'];
        $product->code         = $payload['code'];
        $product->category_id  = $productCategory->id;
        $product->price        = $payload['price'];
        $product->release_date = $payload['release_date'];
        $product->save();
        $this->syncProductTags($product, $payload['tags']);
        return $product;
    }

    /**
     * If the specified tags already exist create entries in the pivot table
     * else store the new tags and then create entries in the pivot table
     * @param Product $product
     * @param array $tags
     * @return bool
     */
    private function syncProductTags(Product $product, array $tags): bool {

        $product->tags()->detach();

        if (empty($tags)) {
            return true;
        }

        $tagsSync = [];
        foreach($tags as $tag) {
            if (!Tag::exists($tag)) {
                $newTag = Tag::create(['tag_name' => $tag]);
                $tagsSync[] = $newTag->id;
            } else {
                $tagsSync[] = Tag::query()->where('tag_name', $tag)->first()?->id;
            }
        }

        $result = [];
        if (!empty($tagsSync)) {
            $result = $product->tags()->sync($tagsSync);
        }
        return (!empty($result));
    }
}
