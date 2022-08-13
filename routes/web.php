<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\Filter\FilterController;
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

Route::prefix('/dashboard/')->name('dashboard.')->group(function (){
    Route::get('defineArticle', [ArticleController::class, 'create'])->name('defineArticle.create');
    Route::post('defineArticle', [ArticleController::class, 'store'])->name('defineArticle.store');

});

//Route to filterController
Route::post('filter', [FilterController::class, 'filter'])->name('filter.filter');
Route::post('showSearch', [FilterController::class, 'showSearch'])->name('showSearch.showSearch');



