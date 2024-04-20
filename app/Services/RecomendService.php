<?php

namespace App\Services;

use App\Models\Article;
use App\Models\ArticleClick;
use App\Repositories\ClickhouseRepository;

class RecomendService
{
    protected $recommendationService;

    public function __construct($recommendationService)
    {
        $this->recommendationService = $recommendationService;
    }

    public static function getRecommendedArticles(string $userIp, int $articleId, string $userAgent)
    {
        ArticleClick::create([
            'ip_address' => $userIp,
            'article_id' => $articleId,
            'user_agent' => $userAgent,
        ]);

        $service = new ClickhouseRepository();
        $service->logArticleView($userIp, $articleId);

        $articles = Article::whereIn('id', $service->getRecommendedArticles($userIp))->get();

        if ($articles->count() < 3) {
            return Article::inRandomOrder()->limit(3)->get();
        }

        return $articles;
    }

    public static function getRecommended(string $userIp)
    {
        $service = new ClickhouseRepository();
//
        $articles = Article::whereIn('id', $service->getRecommendedArticles($userIp))->get();

        if ($articles->count() < 3) {
            return Article::inRandomOrder()->limit(3)->get();
        }

        return $articles;
    }


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
