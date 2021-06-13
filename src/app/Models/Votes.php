<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Votes extends Model
{
    use HasFactory;

    protected $primaryKey = 'vote_id';
    public $timestamps = false;

    protected $fillable = [
      'user_id',
      'article_id'
    ];
}
