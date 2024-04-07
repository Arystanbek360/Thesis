<?php

namespace App\Http\Controllers;

use App\Http\Requests\SearchRequest;
use App\Models\Article;
use App\Models\Category;
use App\Services\RecomendService;
use Illuminate\Http\Request;

class WebController extends Controller
{
    public function show(Request $request, Article $article)
    {
        $categories = Category::whereHas('articles')->get();
        $recomends  = RecomendService::getRecommendedArticles(request()->ip(), $article->id, request()->userAgent());

        return view('show', compact('article', 'categories', 'recomends'));
    }

    public function index()
    {
        $articles   = Article::orderBy('published', 'desc')
            ->whereNotNull('published')
            ->groupBy('title')
            ->selectRaw(
                'MIN(id) as id, title, MIN(short_description) as short_description, MIN(description) as description, MIN(author) as author, MIN(url) as url, MIN(published) as published, MIN(category_id) as category_id, MIN(created_at) as created_at, MIN(updated_at) as updated_at'
            )
            ->paginate(9);
        $categories = Category::whereHas('articles')->get();

        $recomends = RecomendService::getRecommended(request()->ip());
        return view('welcome', compact('articles', 'categories', 'recomends'));
    }

    public function category(Category $category)
    {
        $articles   = $category->articles()->orderBy('published', 'desc')->whereNotNull('published')->paginate(9);
        $categories = Category::whereHas('articles')->get();
        $recomends  = RecomendService::getRecommended(request()->ip());
        return view('welcome', compact('articles', 'categories', 'recomends'));
    }

    public function search(SearchRequest $request)
    {
        $data     = $request->validated();
        $articles = Article::where('title', 'like', '%' . $data['search'] . '%')
            ->orWhere('short_description', 'like', '%' . $data['search'] . '%')
            ->paginate(9);
        return view('search', [
            'articles'   => $articles,
            'categories' => Category::whereHas('articles')->get(),
            'search'     => $data['search'] ?? '',
            'recomends'  => RecomendService::getRecommended(request()->ip()),
        ]);
    }
}
