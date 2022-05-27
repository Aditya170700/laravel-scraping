<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ItemSchemaController;
use App\Http\Controllers\LinkController;
use App\Http\Controllers\WebsiteController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/', [HomeController::class, 'index']);
Route::get('/article-details/{id}', [HomeController::class, 'getArticleDetails']);
Route::get('/category/{id}', [HomeController::class, 'getCategory']);

Route::group(['prefix' => 'dashboard'], function () {
    Route::resource('/websites', WebsiteController::class);
    Route::resource('/categories', CategoryController::class);
    Route::patch('/links/set-item-schema', [LinkController::class, 'setItemSchema']);
    Route::post('/links/scrape', [LinkController::class, 'scrape']);
    Route::resource('/links', LinkController::class);
    Route::resource('/item-schemas', ItemSchemaController::class);
    Route::resource('/articles', ArticleController::class);
});
