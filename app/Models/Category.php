<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'category_id',
        'name',
        'url',
    ];

    public function articles()
    {
        return $this->hasMany(Article::class);
    }
}
