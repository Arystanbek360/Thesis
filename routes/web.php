<?php

use App\Http\Controllers\WebController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [WebController::class, 'index'])->name('index');
Route::get('/show/{article}', [WebController::class, 'show'])->name('show');
Route::get('/category/{category}', [WebController::class, 'category'])->name('category');
Route::get('/search', [WebController::class, 'search'])->name('search');
Route::post('/session/{article}', [WebController::class, 'sessionArticle'])->name('sessionArticle');

