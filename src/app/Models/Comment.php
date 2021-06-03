<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $primaryKey = 'comment_id';


    public function author(){
        return $this->hasOne(User::class, 'user_id', 'author_id');
    }

}
