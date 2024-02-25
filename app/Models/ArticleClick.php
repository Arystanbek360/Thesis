<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArticleClick extends Model
{
    protected $fillable = [
        'ip_address',
        'user_agent',
        'article_id'
    ];

    public function article()
    {
        return $this->belongsTo(Article::class);
    }
}
