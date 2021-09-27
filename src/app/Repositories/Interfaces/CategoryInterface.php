<?php

namespace App\Repositories\Interfaces;

use App\Models\Category;

interface CategoryInterface
{
    public function all();

    public function get(Category $category);

    public function create($data);

    public function update();
}
