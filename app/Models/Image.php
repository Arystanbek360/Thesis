<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Image extends Model
{
    protected $fillable = [
        'article_id',
        'image'
    ];

    public function article(): BelongsTo
    {
        return $this->belongsTo(Article::class);
    }
}
