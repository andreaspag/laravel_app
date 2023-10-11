<?php

namespace App\Repositories\Interfaces;

use App\Models\Tag;
use Illuminate\Support\Collection;

interface TagsRepositoryInterface
{
    public function all(): Collection;
}
