<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Filter\FilterController;
use App\Models\Article;
use App\Http\Requests\StoreArticleRequest;
use App\Http\Requests\UpdateArticleRequest;
use App\Models\Department;
use App\Repositories\ArticleRepository;
use App\Repositories\Filter\FilterRepository;
use \Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(FilterController $filterController, Request $request)
    {
        $results = structuredJson($filterController->retrieveDepartments());
        return response()->json($results[0], $results[1], $results[2], $results[3]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\StoreArticleRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreArticleRequest $request, ArticleRepository $articleRepository)
    {
        $validated = $request->safe()->only(['author', 'title', 'contributors', 'body', 'publishedArticles', 'categories', 'tags', 'messages']);
        $results = structuredJson($articleRepository->create($validated));
        return response()->json($results[0], $results[1], $results[2], $results[3]);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Article $article
     * @return \Illuminate\Http\Response
     */
    public function show(Article $article)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Article $article
     * @return \Illuminate\Http\Response
     */
    public function edit(Article $article)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UpdateArticleRequest $request
     * @param \App\Models\Article $article
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateArticleRequest $request, Article $article)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Article $article
     * @return \Illuminate\Http\Response
     */
    public function destroy(Article $article)
    {
        //
    }

    public function invitationResponse(ArticleRepository $articleRepository, $articleID, $userID, $parameter)
    {
        $results = structuredJson($articleRepository->invitationResponse($articleID, $userID, $parameter));
        return response()->json($results[0], $results[1], $results[2], $results[3]);

    }

    public function deleteContributor(UpdateArticleRequest $request, ArticleRepository $articleRepository)
    {
        $validated = $request->safe()->only('articleID', 'contributors');
        $results = structuredJson($articleRepository->deleteContributor($validated));
        return response()->json($results[0], $results[1], $results[2], $results[3]);

    }

}
