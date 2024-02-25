<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Builder;

class Repository
{
    public const ORDER = 'id';
    public const SORT = 'desc';
    public const PER_PAGE = 20;

    protected function applyOrder(Builder $query, array $params = []): Builder
    {
        $query->orderBy(
            $params['orderBy'] ?? self::ORDER,
            $params['sort'] ?? self::SORT
        );

        return $query;
    }

    protected function applyPagination(Builder $query, array $params = []): Builder
    {
        $perPage = $params['perPage'] ?? self::PER_PAGE;
        $page = $params['page'] ?? 1;

        $startRow = ($page - 1) * $perPage;

        return $query->offset($startRow)->limit($perPage);
    }
}
