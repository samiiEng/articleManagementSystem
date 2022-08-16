<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

use \App\Http\Controllers\ArticleController;
use \App\Http\Controllers\Filter\FilterController;

Route::prefix('dashboard/')->name('dashboard.')->group(function () {
    Route::get('defineArticle', [ArticleController::class, 'create'])->name('defineArticle.create');
    Route::post('filterUsernamesByDepartments', [FilterController::class, 'filterUsernamesByDepartments'])->name('filterUsernamesByDepartments');
    Route::post('filterCategoriesByDepartments', [FilterController::class, 'filterCategoriesByDepartments'])->name('filterCategoriesByDepartments');
    Route::post('filterArticlesByCategoriesDepartments', [FilterController::class, 'filterArticlesByCategoriesDepartments'])->name('filterArticlesByCategoriesDepartments');
    Route::post('storeArticle', [ArticleController::class, 'store'])->name('storeArticle');


    Route::get('hello', function (Request $request) {

    });
});

Route::get('invitationResponse/{articleID}/{userID}/{parameter}', [ArticleController::class, 'invitationResponse'])->name('invitationResponse')->middleware(['signed']);
