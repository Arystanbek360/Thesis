<?php

namespace App\Repositories;

use App\Models\Article;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class ArticleRepository extends Repository
{
    public function getPaginated(array $params = []): Collection
    {
        $query = Article::with('category', 'images');
        $query = $this->applyFilter($query, $params);
        $query = $this->applyOrder($query, $params);
        $query = $this->applyPagination($query, $params);

        return $query->get();
    }

    public function count(array $params = []): int
    {
        $query = Article::query();
        $query = $this->applyFilter($query, $params);

        return $query->count();
    }

    public function applyFilter(Builder $query, array $params = []): Builder
    {
        if (isset($params['author'])) {
            $query->where('author', $params['author']);
        }

        if (isset($params['category_id'])) {
            $query->where('category_id', $params['category_id']);
        }

        if (isset($params['filter'])) {
            $query->where(function ($query) use ($params) {
                $query->where('title', 'LIKE', '%' . $params['filter'] . '%')
                    ->orWhere('short_description', 'LIKE', '%' . $params['filter'] . '%')
                    ->orWhere('description', 'LIKE', '%' . $params['filter'] . '%')
                    ->orWhere('author', 'LIKE', '%' . $params['filter'] . '%');
            });
        }


        return $query;
    }

}
