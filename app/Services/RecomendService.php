<?php

namespace App\Services;

use App\Models\Article;
use App\Models\ArticleClick;

class RecomendService
{
    public static function getRecomends(array $data)
    {
        $clickedArticleIds = ArticleClick::where('ip_address', $data['ip'])->get();

        if ($clickedArticleIds->count() < 5) {
            return Article::inRandomOrder()->limit(3)->get();
        }


        $clickedArticleIds = ArticleClick::where('ip_address', $data['ip'])
            ->pluck('article_id')
            ->toArray();

        $clickedArticles = ArticleClick::where('ip_address', $data['ip'])
            ->with('article')
            ->get();

        $categories = $clickedArticles->groupBy('article.category_id')
            ->map(function ($clicks) {
                return $clicks->count();
            })
            ->sortDesc();

        $similarArticles = Article::whereIn('category_id', $categories->keys()->toArray())
            ->whereNotIn('id', $clickedArticleIds)
            ->limit(3)
            ->get();

        return $similarArticles;
    }
}
