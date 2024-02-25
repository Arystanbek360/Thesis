<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ArticleSession extends Model
{
    protected $fillable = [
        'ip_address',
        'user_agent',
        'article_id',
        'duration',
    ];

    public function article()
    {
        return $this->belongsTo(Article::class);
    }
}
