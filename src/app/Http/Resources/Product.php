<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class Product extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'           => $this->id,
            'name'         => $this->name,
            'code'         => $this->code,
            'category'     => $this->category()->first()->category_name,
            'price'        => $this->price,
            'release_date' => $this->release_date,
            'tags'         => $this->tags()->get()->map(function($tag) {
                                    return $tag->tag_name;
                              })
        ];
    }
}
