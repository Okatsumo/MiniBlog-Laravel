<?php

namespace App\Repositories;

use App\Models\Article;
use App\Models\Category;
use App\Repositories\Interfaces\CategoryInterface;

class CategoryRepository implements CategoryInterface
{
    public function all()
    {
        return Category::all();
    }

    public function get(Category $category)
    {
        $article = new Article();

        return $article->where('category_id', '=', $category->category_id);
    }

    public function create($data)
    {
        return Category::create($data);
    }

    public function update()
    {
        // TODO: Implement update() method.
    }
}
