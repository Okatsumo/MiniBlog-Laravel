<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Category extends Model
{
    use HasFactory;

    protected $primaryKey = 'category_id';
    public $timestamps = false;

    protected $fillable = ['name'];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->leftJoin('articles', 'categories.category_id', '=', 'category_id')
            ->groupBy('category_id');
//            ->get('*', DB::raw('COUNT(1)'))
    }
}
