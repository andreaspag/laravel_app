<?php

namespace App\Repositories;

use App\Models\Tag;
use App\Repositories\Interfaces\TagsRepositoryInterface;
use Illuminate\Support\Collection;

class TagRepository implements TagsRepositoryInterface
{
    public function all(): Collection {
        return Tag::all();
    }
}
