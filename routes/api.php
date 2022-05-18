<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ArticleController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


// List articles
//Route::get('articles', 'ArticleController@index');

Route::get('articles', [ArticleController::class, 'index'])->name('articleIndex');

// List single article
Route::get('article/{id}', [ArticleController::class, 'show'])->name('articleShow');

// Create new article
Route::post('article', [ArticleController::class, 'store'])->name('articleStore');

// Update article
Route::put('article', [ArticleController::class, 'store'])->name('articleStore');

// Delete article
Route::delete('article/{id}', [ArticleController::class, 'destroy'])->name('articleDestroy');
