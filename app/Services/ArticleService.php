<?php

namespace App\Services;

use App\Http\Resources\ArticleResource;
use App\Repositories\ArticleRepository;

class ArticleService
{
    public function __construct(public ArticleRepository $articleRepository)
    {
    }

    public function getPaginated(array $params = []): array
    {
        return [
            'list' => ArticleResource::collection($this->articleRepository->getPaginated($params)),
            'count' => $this->articleRepository->count($params),
        ];
    }

}
