<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\ArticleClick;
use Illuminate\Http\Request;

class WebController extends Controller
{
    public function show(Request $request, Article $article)
    {
        ArticleClick::create([
            'ip_address' => $request->ip(),
            'article_id' => $article->id,
        ]);

        return view('show', compact('article'));
    }

    public function index()
    {
        $articles = Article::orderBy('published', 'asc')->whereNotNull('published')->paginate(9);
        return view('welcome', compact('articles'));
    }
}
