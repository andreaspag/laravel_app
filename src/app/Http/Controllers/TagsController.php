<?php

namespace App\Http\Controllers;

use App\Http\Resources\TagCollection;
use App\Repositories\Interfaces\TagsRepositoryInterface;
use Illuminate\Http\Request;
use App\Models\Tag;

class TagsController extends Controller
{

    public function __construct(private TagsRepositoryInterface $tagsRepository) {

    }

    public function all() {
        return new TagCollection($this->tagsRepository->all());
    }
}
