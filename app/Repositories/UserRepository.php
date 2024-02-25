<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

class UserRepository extends Repository
{
    public function getPaginated(array $params = []): Collection
    {
        $query = User::with('city', 'shop');
        $query = $this->applyFilter($query, $params);
        $query = $this->applyOrder($query, $params);
        $query = $this->applyPagination($query, $params);

        return $query->get();
    }

    public function count(array $params = []): int
    {
        $query = User::query();
        $query = $this->applyFilter($query, $params);

        return $query->count();
    }

    public function applyFilter(Builder $query, array $params = []): Builder
    {
        if (isset($params['ids'])) {
            $query->whereIn('id', $params['ids']);
        }

        if (isset($params['role'])) {
            $query->where('role', $params['role']);
        }

        if (isset($params['roles'])) {
            $query->whereIn('role', $params['roles']);
        }

        if (isset($params['filter'])) {
            $query->where(function ($query) use ($params) {
                $query->where('name', 'ilike', '%' . $params['filter'] . '%')
                    ->orWhere('phone', 'ilike', '%' . $params['filter'] . '%')
                    ->orWhere('email', 'ilike', '%' . $params['filter'] . '%');
            });
        }

        return $query;
    }

    public function create(array $data): User
    {
        return User::create($data);
    }
}
