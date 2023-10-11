<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = ['tag_name'];

    public function products(): BelongsToMany {
        return $this->belongsToMany(Product::class, 'products_tag', 'tag_id', 'product_id');
    }

    public static function exists(string $tagName): bool {
        return self::query()->where('tag_name', $tagName)->exists();
    }
}
