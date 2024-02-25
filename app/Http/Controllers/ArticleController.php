<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClickRequest;
use App\Http\Requests\IndexRequest;
use App\Http\Requests\SessionRequest;
use App\Models\ArticleClick;
use App\Models\ArticleSession;
use App\Services\ArticleService;

class ArticleController extends Controller
{
    public function __construct(public ArticleService $articleService)
    {
    }

    public function article(IndexRequest $request)
    {
        return response()->json($this->articleService->getPaginated($request->validated()));
    }

    public function storeClick(ClickRequest $request)
    {
        $data = $request->validated();
        $click = ArticleClick::create([
            'ip_address' => $data['ip_address'],
            'article_id' => $data['article_id'],
            'user_agent' => $data['user_agent'],
//            $request->validated()
        ]);

        return response()->json(['success' => true, 'data' => $click]);
    }

    public function storeSession(SessionRequest $request)
    {
        $data = $request->validated();

        $session = ArticleSession::create([
            'ip_address' => $data['ip'],
            'article_id' => $data['article_id'],
            'duration'   => $data['duration'],
            'user_agent' => $data['user_agent'],
        ]);

        return response()->json(['success' => true, 'data' => $session]);
    }
}
