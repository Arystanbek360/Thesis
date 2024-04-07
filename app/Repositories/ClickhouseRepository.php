<?php

namespace App\Repositories;

use ClickHouseDB\Client;

class ClickhouseRepository
{
    private Client $clickhouse;

    public function __construct()
    {
        $this->clickhouse = new Client(config('clickhouse'));
    }

    public function all(string $query, array $bindings = [])
    {
        return $this->clickhouse->select($query, $bindings)->rows();
    }

    public function write(string $sql): void
    {
        $this->clickhouse->write($sql);
    }

    public function pluck(string $query, array $bindings = [], string $column): array
    {
        return array_column(
            $this->clickhouse->select($query, $bindings)->rows(),
            $column
        );
    }

    public function insert(string $table, array $data, array $columns)
    {
        return $this->clickhouse->insert(
            $table,
            $data,
            $columns
        );
    }

    public function logArticleView(string $userIp, int $articleId)
    {
        $this->clickhouse->insert(
            'article_views',
            [['user_ip' => $userIp, 'article_id' => $articleId]],
            ['user_ip', 'article_id']
        );
    }

    public function getRecommendedArticles(string $userIp)
    {
        $userViewsResult = $this->clickhouse->select(
            'SELECT article_id FROM article_views WHERE user_ip = :userIp',
            ['userIp' => $userIp]
        );

        $currentUserViews = [];
        foreach ($userViewsResult->rows() as $row) {
            $currentUserViews[] = $row['article_id'];
        }

        // Получаем список всех просмотров, сгруппированных по пользователям
        $allUserViews = $this->clickhouse->select(
            'SELECT user_ip, article_id FROM article_views WHERE user_ip != :userIp',
            ['userIp' => $userIp]
        )->rows();

        // Словарь, в котором ключ - это пользователь, а значение - список его просмотров
        $userViewsMap = [];
        foreach ($allUserViews as $view) {
            $userIp    = $view['user_ip'];
            $articleId = $view['article_id'];
            if (!isset($userViewsMap[$userIp])) {
                $userViewsMap[$userIp] = [];
            }
            $userViewsMap[$userIp][] = $articleId;
        }

        // Находим пользователя с наибольшим количеством совпадающих просмотров
        $bestMatchUser  = null;
        $bestMatchCount = 0;
        foreach ($userViewsMap as $userIp => $userViews) {
            $matchCount = count(array_intersect($currentUserViews, $userViews));
            if ($matchCount > $bestMatchCount) {
                $bestMatchUser  = $userIp;
                $bestMatchCount = $matchCount;
            }
        }

        // Получаем список статей, которые просмотрел найденный пользователь, но не просмотрел текущий пользователь
        $recommendedArticles = [];
        if ($bestMatchUser) {
            $recommendedArticles = array_diff($userViewsMap[$bestMatchUser], $currentUserViews);
        }

        // Убираем повторяющиеся айдишники
        $recommendedArticles = array_unique($recommendedArticles);

        if (empty($recommendedArticles)) {
            $notViewedArticles = [];
            foreach ($userViewsMap as $userViews) {
                $notViewedArticles = array_merge($notViewedArticles, array_diff($userViews, $currentUserViews));
            }

            $recommendedArticles = array_unique($notViewedArticles);
        }

        return $recommendedArticles;
    }

}
