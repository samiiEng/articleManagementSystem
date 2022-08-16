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

    //*******************define article
    Route::get('defineArticle', [ArticleController::class, 'create'])->name('defineArticle.create');
    Route::post('storeArticle', [ArticleController::class, 'store'])->name('storeArticle');

    //*******************filtering
    Route::post('filterUsernamesByDepartments', [FilterController::class, 'filterUsernamesByDepartments'])->name('filterUsernamesByDepartments');
    Route::post('filterCategoriesByDepartments', [FilterController::class, 'filterCategoriesByDepartments'])->name('filterCategoriesByDepartments');
    Route::post('filterArticlesByCategoriesDepartments', [FilterController::class, 'filterArticlesByCategoriesDepartments'])->name('filterArticlesByCategoriesDepartments');

    //*******************list articles
    /* 1- Does filter by if it is or is not published
     * 2- For sending less data to the front-end we let the user check the isPublished filter checkbox and
     * get the data from the server By Ajax or ....
     */
    Route::get('listArticles/{isPublished}', [ArticleController::class, 'index'])->name('listArticles')->where(['isPublished' => '[01]']);
    Route::get('showArticle/{articleID}', [ArticleController::class, 'show'])->name('showArticle');
    Route::get('editArticle/{articleID}', [ArticleController::class, 'edit'])->name('editArticle');
    Route::get('deleteArticle/{articleID}', [ArticleController::class, 'softDelete'])->name('deleteArticle');


    //*******************edit article

    Route::post('deleteContributor', [ArticleController::class, 'deleteContributor'])->name('deleteContributor');


    //login/register
    Route::get('editArticle', [ArticleController::class, 'edit'])->name('editArticle');


    Route::get('hello', function (Request $request) {

    });
});

Route::get('invitationResponse/{articleID}/{userID}/{parameter}', [ArticleController::class, 'invitationResponse'])->name('invitationResponse')->middleware(['signed']);
