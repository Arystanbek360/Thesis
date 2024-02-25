<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ArticleResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'short_description' => $this->short_description,
            'description' => $this->description,
            'category' => CategoryResource::make($this->category),
            'author' => $this->author,
            'published' => $this->published,
            'images' => ImageResource::collection($this->images),
        ];
    }
}
