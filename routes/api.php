<?php

use App\Http\Controllers\ArticleController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('/article', [ArticleController::class, 'article']);
Route::post('/article-click', [ArticleController::class, 'storeClick']);
Route::post('/article-session', [ArticleController::class, 'storeSession']);


